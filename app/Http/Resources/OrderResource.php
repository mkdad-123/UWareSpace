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
            'id' => $this->id,
            'payment_type' => $this->payment_type,
            'payment_at' => $this->payment_at,
            'purchase_order' => new PurchaseOrderResource($this->whenLoaded('purchase_order')),
            'items' =>  OrderItemResource::collection($this->whenLoaded('order_items')),
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
        ];
    }
}
