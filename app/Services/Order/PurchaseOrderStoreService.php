<?php

namespace App\Services\Order;

use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PurchaseOrderStoreService extends OrderStoreService
{

    protected function storePurchaseOrder($orderId ,$supplierId)
    {
        PurchaseOrder::create([
            'order_id' => $orderId,
            'supplier_id' => $supplierId,
        ]);
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $warehouse = Warehouse::find($request->input('warehouse_id'));

            $items = $request->input('items');

            $loadedItemsById = $this->loadItems($items);

            $percent = $this->calculateCapacity($items ,$loadedItemsById , $warehouse->size_cubic_meters );

            $capacity_percent = round(($warehouse->current_capacity + $percent) , 2);

            if($capacity_percent > 100)
            {
                return $this->result = new OperationResult (
                    'The warehouse capacity is not enough, the percent capacity becomes '. $capacity_percent,
                    response(),
                    400
                );
            }
            $price = $this->calculatePrice($items , $loadedItemsById);

            $orderId  = $this->storeOrder($request->only(['warehouse_id' , 'payment_type' , 'payment_at']) , $price);

            $this->addCache($orderId , $percent);

            $this->storePurchaseOrder($orderId , $request->input('supplier_id'));

            $this->storeOrderItems($orderId ,$items);

            DB::commit();

            $this->result = new OperationResult('Order has been created successfully , the percent capacity will become '. $capacity_percent.' %' ,
                 response(),
                201
            );

        } catch (QueryException $e) {

            DB::rollBack();

             $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

             $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }

        return $this->result;
    }
}
