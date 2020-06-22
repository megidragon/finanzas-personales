<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MovementListResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        foreach ($this->collection as $k => $row)
        {
            $data[] = [
                'date_at' => $row->date_at,
                'amount' => $row->amount,
                'category' => $row->category->name,
                'currency' => $row->currency->symbol,
                'type' => $row->type
            ];
        }

        return $data;
    }
}
