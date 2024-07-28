<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size_cubic_meters,
            'capacity' => $this->current_capacity,
            'location' => $this->location,
        ];


        if($this->relationLoaded('items'))
        {
            $data['items'] = $this->items->map(function ($item){
                return [
                    'id' => $item->id,
                    'SKU' => $item->SKU,
                    'name' => $item->name,
                    'sell_price' => $item->sell_price,
                    'pur_price' => $item->pur_price,
                    'size_cubic_meters' => $item->size_cubic_meters,
                    'weight' => $item->weight,
                    'str_price' => $item->str_price,
                    'total_qty' => $item->total_qty,
                    'photo' => $item->photo,
                    'unit' => $item->unit,
                    'real_qty' => $item->pivot->real_qty,
                    'min_qty' => $item->pivot->min_qty,
                    'available_qty' => $item->pivot->available_qty,
                ];
            });
        }

        if($this->relationLoaded('vehicles')){

            $data['vehciles'] = $this->vehicles->map(function ($vehicle){
                return [
                    'id' => $vehicle->id,
                    'name' => $vehicle->name,
                    'size_cubic_meters' => $vehicle->size_cubic_meters,
                    'load_capacity_kg' => $vehicle->load_capacity_kg,
                    'plate_number' => $vehicle->plate_number,
                    'status' => $vehicle->status,
                ];
            });
        }

        return $data;
    }
}
