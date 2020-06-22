<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MovementBalanceResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dates = [];
        foreach ($this->collection->toArray() as $k => $row)
        {
            if (!isset($dates[$row['date_at']]))
            {
                $dates[$row['date_at']] = [];
            }
            if (!isset($dates[$row['date_at']]['balance']))
            {
                $dates[$row['date_at']]['balance'] = [];
            }
            if (!isset($dates[$row['date_at']]['expenses']))
            {
                $dates[$row['date_at']]['expenses'] = [];
            }
            if (!isset($dates[$row['date_at']]['deposits']))
            {
                $dates[$row['date_at']]['deposits'] = [];
            }

            $dates[$row['date_at']]['balance'][$row['currency']['symbol']] = $row['balance'];
            $dates[$row['date_at']]['expenses'][$row['currency']['symbol']] = $row['expenses'];
            $dates[$row['date_at']]['deposits'][$row['currency']['symbol']] = $row['deposits'];
        }

        return $dates;
    }
}
