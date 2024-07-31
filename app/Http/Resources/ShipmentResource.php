<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
              'id' => $this->id,
              'tracking_number' => $this->tracking_number,
              'current_capacity' => $this->current_capacity,
              'status' => $this->status,
              'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
              'employee' => new EmployeeResource($this->whenLoaded('employee')),
              'vehicle' => new VehicleResource($this->whenLoaded('vehicle'))
        ];
    }
}
