<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\SellOrder */
class SellOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'client' => new MemberResource($this->whenLoaded('client')),
            'shipment' =>new ShipmentResource($this->whenLoaded('shipment')),
        ];
    }
}
