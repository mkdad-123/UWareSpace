<?php

namespace App\Services;

use App\Models\Quality;
use Illuminate\Support\Facades\DB;

class QualityService
{
    public function storeExpirationDate($itemId , $data , $warehouseId)
    {
        $warehouseItem = DB::table('warehouse_item')->where('warehouse_id' , $warehouseId)
            ->where('item_id' , $itemId)->first('id');

        Quality::query()->create([
            'item_id' => $warehouseItem->id,
            'expiration_date' => $data['expiration_date'],
            'quantity' => $data['real_quantity'],
        ]);
    }
}
