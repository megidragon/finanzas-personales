<?php

namespace App\Http\Repositories;

use App\Movements;
use App\User;
use App\Http\Resources\MovementBalanceResource;
use App\Http\Resources\MovementExpensesResource;
use App\Http\Resources\MovementCategoryExpensesResource;

class MovementRepository
{
    /**
     * Crea un nuevo movimiento
     */
    public static function newMovement(string $title, string $description, float $amount, int $category_id, int $currency_id, string $type) : void
    {
        $client_id = User::clientId(auth()->id());
        Movements::create([
          'title' => $title,
          'description' => $description,
          'amount' => $amount,
          'type' => $type,
          'category_id' => $category_id,
          'currency_id' => $currency_id,
          'client_id' => $client_id
        ]);
    }

    /**
     * Obtiene el balance acumuado agrupado por dia del mes seleccionado
     * 
     * @param int $year Año numerico entre 1950 y 2500
     * @param int $month Año numerico entre 1-12
     */
    public static function getBalance($year, $month)
    {
        $client_id = User::clientId(auth()->id());
        $deposit_subquery = "IFNULL((
            SELECT 
                SUM(m2.amount) 
            FROM movements m2
            WHERE DATE_FORMAT(m2.created_at, '%Y-%m-%d') <= DATE_FORMAT(movements.created_at, '%Y-%m-%d') AND m2.client_id = $client_id AND m2.`type` = '".\Config::get('constants.DEPOSIT_KEY')."' 
        ), 0)";
        $spending_subquery = "IFNULL((
            SELECT 
                SUM(m2.amount) 
            FROM movements m2
            WHERE DATE_FORMAT(m2.created_at, '%Y-%m-%d') <= DATE_FORMAT(movements.created_at, '%Y-%m-%d') AND m2.client_id = $client_id AND m2.`type` = '".\Config::get('constants.SPENDING_KEY')."'
        ), 0)";

        $balance_subquery = "
            # Trae los ingresos
            $deposit_subquery - 
            # Trae los gastos
            $spending_subquery
        ";

        // Laravel no soporta acumulados asi que se hace manual
        $balance = Movements::ownedByClient($client_id)
                        ->select(
                            \DB::raw("DATE_FORMAT(movements.created_at, '%Y-%m-%d') AS 'date_at'"),
                            \DB::raw("ROUND($spending_subquery, 2) AS 'expenses'"),
                            \DB::raw("ROUND($balance_subquery, 2) AS 'balance'"),
                            'currency_id'
                        )
                        ->with(['currency'])
                        ->where('type', \Config::get('constants.DEPOSIT_KEY'))
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->groupBy('currency_id', 'date_at', 'balance', 'expenses')
                        ->get();
        return new MovementBalanceResource($balance);
    }

    /**
     * Obtiene los gastos agrupado por dia del mes seleccionado
     * 
     * @param int $year Año numerico entre 1950 y 2500
     * @param int $month Año numerico entre 1-12
     */
    public static function dailyExpenseReport($year, $month) : object
    {
        $client_id = User::clientId(auth()->id());
        $expenses = Movements::ownedByClient($client_id)
                        ->select(
                            \DB::raw("DATE_FORMAT(movements.created_at, '%Y-%m-%d') AS 'date_at'"),
                            \DB::raw("ROUND(SUM(amount), 2) AS 'expense'"),
                            'currency_id'
                        )
                        ->with(['currency'])
                        ->where('type', \Config::get('constants.SPENDING_KEY'))
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->groupBy('currency_id', 'date_at')
                        ->get();
        return new MovementExpensesResource($expenses);
    }

    /**
     * Obtiene los movimientos de la base de datos
     */
    public static function getMovements()
    {
        $client_id = User::clientId(auth()->id());
        return Movements::ownedByClient($client_id)->with(['category', 'currency'])->get();
    }
    
    /**
     * Obtiene los gastos agrupados por categoria
     * 
     * @param int $year Año numerico entre 1950 y 2500
     * @param int $month Año numerico entre 1-12
     */
    public static function categoryExpenseReport($year, $month)
    {
        $client_id = User::clientId(auth()->id());
        $expenses = Movements::ownedByClient($client_id)
                        ->select(
                            \DB::raw("ROUND(SUM(amount), 2) AS 'expense'"),
                            'currency_id',
                            'category_id'
                        )
                        ->with(['currency', 'category'])
                        ->where('type', \Config::get('constants.SPENDING_KEY'))
                        ->whereYear('created_at', '=', $year)
                        ->whereMonth('created_at', '=', $month)
                        ->groupBy('category_id', 'currency_id')
                        ->get();
        return new MovementCategoryExpensesResource($expenses);
    }
}