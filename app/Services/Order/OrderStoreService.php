<?php

namespace App\Services\Order;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Illuminate\Support\Facades\Cache;

class OrderStoreService
{
    protected OperationResult $result;

    public function calculateCapacity($items ,$size): float
    {
        $itemIds = array_column($items,'id');

        $loadedItems = Item::whereIn('id' , $itemIds)->get()->keyBy('id');

        $total = 0.0;

        foreach ($items as $item )
        {
            $itemSize = $loadedItems[$item['id']]->size_cubic_meters;

            $total += calculate_capacity($size , $itemSize , $item['quantity']);
        }

        return $total;
    }

    protected function storeOrder($data)
    {
        $order = Order::create($data);

        return $order->id;
    }

    protected function storeOrderItems($orderId , $items): void
    {
        foreach ($items as $item)
        {
            OrderItem::create([
                'order_id' => $orderId,
                'item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }
    }

    protected function addCache($orderId ,$percent): void
    {
        $cacheKey = "order_capacity_{$orderId}";

        Cache::put($cacheKey , $percent , 22880);
    }


}
