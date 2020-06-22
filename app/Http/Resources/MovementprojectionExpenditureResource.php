<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Helpers\Math;

class MovementprojectionExpenditureResource extends ResourceCollection
{
    use Math;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dates = [];
        $data = $this->collection->toArray();
        $currencies = [];
        $last_value_per_currency = [];
        $count_dates_per_currency = [];

        foreach ($data as $k => $row)
        {
            if (!isset($count_dates_per_currency[$row['currency']['symbol']]))
            {

                $count_dates_per_currency[$row['currency']['symbol']] = 0;
            }
            $count_dates_per_currency[$row['currency']['symbol']] ++;

            if (!isset($dates[$row['date_at']]))
            {
                $dates[$row['date_at']] = [];
            }
            
            // Añade el valor del mes de la moneda de la lista de fechas
            $dates[$row['date_at']][$row['currency']['symbol']] = $row['expense'];

            // Añade el primer valor de una moneda que se encuentra.
            if (!in_array($row['currency']['symbol'], array_column($currencies, 'currency')))
            {
                $currencies[] = [
                    'currency' => $row['currency']['symbol'],
                    'expense' => $row['expense']
                ];
            }

            // Redefine last_value_per_currency cada vez que itera una moneda, de forma que quede la ultima vez que itero x moneda
            if (!isset($last_value_per_currency[$row['currency']['symbol']]))
            {
                $last_value_per_currency[$row['currency']['symbol']] = [];
            }
            $last_value_per_currency[$row['currency']['symbol']] = $row['expense'];
        }

        // Saca el siguiente mes del ultimo registrado
        $date = new \DateTime($data[count($data)-1]['date_at'].'-01');
        $date->add(new \DateInterval('P1M'));

        $projected_date = [];
        foreach ($currencies as $curr)
        {
            $projected_date[$curr['currency']] = $this->linearExtrapolation(
                $curr['expense'], // Valor del primer mes registrado
                $count_dates_per_currency[$curr['currency']] - 1, // Cantidad de meses entre el primer mes registrado y el ultimo de la moneda de iteracion
                $last_value_per_currency[$curr['currency']], // Ultimo valor registrado del ultimo mes de la moneda de iteracion
                $count_dates_per_currency[$curr['currency']] // Cantidad de meses registrados de la moneda + 1
            );
        }

        $dates[$date->format('Y-m')] = $projected_date;

        return $dates;
    }
}
