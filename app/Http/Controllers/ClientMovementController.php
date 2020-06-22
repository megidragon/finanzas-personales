<?php

namespace App\Http\Controllers;

use App\Helpers\Responses;
use App\Helpers\ValidationHelper;
use App\Http\Repositories\MovementRepository;
use App\Http\Requests\MovementCreateRequest;
use App\Http\Requests\MovementUpdateRequest;
use App\Movements;
use App\User;
use Illuminate\Http\Request;

class ClientMovementController extends Controller
{
    use Responses, ValidationHelper;

    /**
     * Obtiene balance del cliente
     */
    public function getBalance(Request $request)
    {
        $request->validate([
            'month' => 'required|numeric|min:0|max:12',
            'year' => 'required|numeric|min:1950|max:2500',
        ]);

        $balance = MovementRepository::getBalance($request->year, $request->month);
        return $this->listResponse(['balance' => $balance]);
    }
    
    /**
     * Obtiene balance del cliente
     */
    public function dailyExpensesReport(Request $request)
    {
        $request->validate([
            'month' => 'required|numeric|min:0|max:12',
            'year' => 'required|numeric|min:1950|max:2500',
        ]);

        $expenses = MovementRepository::dailyExpenseReport($request->year, $request->month);
        return $this->listResponse(['expenses' => $expenses]);
    }
    
    /**
     * Obtiene balance del cliente
     */
    public function categoryExpensesReport(Request $request)
    {
        $request->validate([
            'month' => 'required|numeric|min:0|max:12',
            'year' => 'required|numeric|min:1950|max:2500',
        ]);

        $expenses = MovementRepository::categoryExpenseReport($request->year, $request->month);
        return $this->listResponse(['expenses' => $expenses]);
    }
    
    /**
     * Obtiene balance del cliente
     */
    public function projectionExpenditureReport()
    {
        $projection = MovementRepository::projectionExpenditureReport();
        return $this->listResponse(['projection' => $projection]);
    }

    /**
     * Crea nuevo movimiento
     */
    public function newMovement(MovementCreateRequest $request)
    {
        if (!$this->checkValidation($request))
        {
            return $this->validateFailed($request->validator->errors());
        }
        
        MovementRepository::newMovement(
            $request->title,
            $request->description,
            $request->amount,
            $request->category_id,
            $request->currency_id,
            $request->type
        );

        return $this->storeSuccess();
    }
    
    /**
     * Listado de movimientos del cliente
     */
    protected function list(Request $request) 
    {
        $request->validate([
            'month' => 'numeric|min:0|max:12',
            'year' => 'numeric|min:1950|max:2500',
        ]);

        $rows = MovementRepository::getMovements();
        
        return $this->listResponse($rows);
    }

    /**
     * Actualizacion de movimiento
     */
    protected function update(MovementUpdateRequest $request, $id) 
    {
        // Validaciones correspondientes
        if (!$this->checkValidation($request))
        {
            return $this->validateFailed($request->validator->errors());
        }

        $client_id = User::clientId(auth()->id());
        $movement = Movements::ownedByClient($client_id)->where('id', $id)->first();
        if (!$movement || $movement->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $input = $request->only([
            'title',
            'description',
            'amount',
            'type',
            'category_id',
            'currency_id',
        ]);

        $movement->fill($input)->save();

        return $this->updateSuccess($movement->fresh());
    }

    /**
     * Borrado de movimiento
     */
    protected function delete($id) 
    {
        $client_id = User::clientId(auth()->id());
        $movement = Movements::ownedByClient($client_id)->where('id', $id)->first();
        if (!$movement || $movement->trashed()) 
        {
            return $this->validateFailed('No se encontro el id solicitado');
        }

        $movement->delete();

        return $this->deleteSuccess();
    }
}
