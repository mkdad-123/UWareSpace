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
            'capacity' => $this->current_capacity
        ];

        if($this->location){
            $data['location'] = $this->location;
        }



        return $data;
    }
}
