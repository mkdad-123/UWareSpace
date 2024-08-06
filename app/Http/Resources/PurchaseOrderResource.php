<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PurchaseOrder */
class PurchaseOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'order' => new OrderResource($this->whenLoaded('order')),
            'supplier' => new MemberResource($this->whenLoaded('supplier')),
        ];
    }
}
