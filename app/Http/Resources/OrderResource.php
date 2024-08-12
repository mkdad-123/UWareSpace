<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'price' => $this->price,
            'payment_type' => $this->payment_type,
            'payment_at' => $this->payment_at,
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
            'items' =>  OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
