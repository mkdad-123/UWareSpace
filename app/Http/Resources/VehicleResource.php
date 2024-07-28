<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'size_cubic_meters' => $this->size_cubic_meters,
            'load_capacity_kg' => $this->load_capacity_kg,
            'plate_number' => $this->plate_number,
            'status' => $this->status,
        ];

        return $data;
    }
}
