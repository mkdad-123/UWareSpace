<?php

namespace App\Services\Order;

use App\Models\Item;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Purchase_Order;
use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PurchaseOrderStoreService
{
    protected OperationResult $result;

    public function calculateCapacity($items ,$warehouseSize )
    {
        $itemIds = array_column($items,'id');

        $loadedItems = Item::whereIn('id' , $itemIds)->get()->keyBy('id');

        $total = 0.0;

        foreach ($items as $loadedItems)
        {
            $itemSize = $loadedItems['id']->size_cubic_meters;

            $total += calculate_capacity($warehouseSize , $itemSize , $loadedItems['quantity']);
        }
        return $total;
    }

    protected function storeOrder($data)
    {
        $order = Order::create($data);

        return $order->id;
    }

    protected function storePurchaseOrder($orderId ,$supplierId)
    {
        Purchase_Order::create([
            'order_id' => $orderId,
            'supplier_id' => $supplierId,
        ]);
    }

    protected function storeOrderItems($orderId , $items)
    {
        foreach ($items as $item)
        {
            Order_item::create([
                'order_id' => $orderId,
                'item_id' => $item['id'],
                'quantity' => $item['quantity'],
            ]);
        }
    }

    protected function addCache($orderId ,$percent)
    {
        $cacheKey = "order_capacity_{$orderId}";

        Cache::put($cacheKey , $percent , 22880);
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $warehouse = Warehouse::find($request->input('warehouse_id'));

            $items = $request->input('items');

            $percent = $this->calculateCapacity($items ,$warehouse->size_cubic_meters );

            $capacity_percent = round(($warehouse->current_capacity + $percent) , 2);

            if($capacity_percent > 100)
            {
                return $this->result = new OperationResult (
                    'The warehouse capacity is not enough, the percent capacity becomes '. $capacity_percent,
                    response(),
                    400
                );
            }

            $orderId  = $this->storeOrder($request->only(['warehouse_id' , 'payment_type' , 'payment_at']));

            $this->addCache($orderId , $percent);

            $this->storePurchaseOrder($orderId , $request->input('supplier_id'));

            $this->storeOrderItems($orderId ,$items);

            DB::commit();

            $this->result = new OperationResult('Order has been created successfully , the percent capacity will become '. $capacity_percent ,
                 response(),
                201
            );

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }

        return $this->result;
    }
}
