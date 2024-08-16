<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OrderChangeStatusService
{
    protected OperationResult $result;

    public function __construct(protected PurchaseOrderStoreService $orderStoreService)
    {}

    protected function changeStatus(Order $order ,string $status )
    {
        $order->purchaseOrder->status = $status;

        $order->purchaseOrder->save();
    }

    protected function changeCapacity(Warehouse $warehouse ,Order $order)
    {
        $cacheKey = "order_capacity_{$order->id}";

        $percent = Cache::pull($cacheKey);

        if(is_null($percent)) {

            $items = $order->load('orderItems')->orderItems->map(function ($item){
                return [
                    "id" => $item->item_id,
                    "quantity" => $item->quantity
                ];
            });

            $loadedItemsById = $this->orderStoreService->loadItems($items->toArray());

            $percent = $this->orderStoreService->calculateCapacity($items ,$loadedItemsById , $warehouse->size_cubic_meters );
        }

        $warehouse->current_capacity += $percent;
        $warehouse->save();
    }

    public function changePurchaseStatus($request , $purchaseOrder)
    {
        try {

            DB::beginTransaction();

            $status = $request->input('status');

            $order = $purchaseOrder->order;

            $warehouse = $order->warehouse;

            $this->changeStatus($order, $status);

            if ($status === 'received')
            {
                $this->changeCapacity($warehouse , $order);
            }

            $this->result = new OperationResult('Order status has been updated successfully' , response(),200);

            DB::commit();

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        }
        catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }

        return $this->result;
    }
}
