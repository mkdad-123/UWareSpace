<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'SKU' => $this->SKU,
            'name' => $this->name,
            'sell_price' => $this->sell_price,
            'pur_price' => $this->pur_price,
            'size_cubic_meters' => $this->size_cubic_meters,
            'weight' => $this->weight,
            'str_price' => $this->str_price,
            'total_qty' => $this->total_qty,
            'photo' => $this->photo ,
            'unit' => $this->unit,
        ];

        return $data;
    }
}
