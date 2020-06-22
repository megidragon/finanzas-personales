<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MovementExpensesResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
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
            
            $dates[$row['date_at']][$row['currency']['symbol']] = $row['expense'];
        }

        return $dates;
    }
}
