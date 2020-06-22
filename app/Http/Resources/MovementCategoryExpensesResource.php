<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MovementCategoryExpensesResource extends ResourceCollection
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
            if (!isset($dates[$row['category']['name']]))
            {
                $dates[$row['category']['name']] = [];
            }
            
            $dates[$row['category']['name']][$row['currency']['symbol']] = $row['expense'];
        }

        return $dates;
    }
}
