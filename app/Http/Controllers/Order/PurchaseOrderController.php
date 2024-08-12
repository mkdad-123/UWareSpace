<?php

namespace App\Http\Controllers\Order;

use App\filters\PurchaseOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\BatchRequest;
use App\Http\Requests\Order\PurchaseOrderRequest;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\Order;
use App\Models\PurchaseOrder;
use App\Services\Item\ItemStoreService;
use App\Services\Item\ItemUpdateService;
use App\Services\Order\PurchaseOrderStoreService;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseOrderController extends Controller
{

    public function showAll()
    {
        $admin = auth('admin')->user() ?: auth('employee')->user()->admin;

        $purchaseOrders = $admin->load([
            'purchaseOrders.order.warehouse', 'purchaseOrders.supplier',
        ])->purchaseOrders()
            ->with(['order.warehouse', 'supplier'])->purchaseOrder();

        $purchases = QueryBuilder::for($purchaseOrders)
            ->allowedFilters(PurchaseOrderFilter::filter($admin->id))
            ->with(['order.warehouse', 'supplier'])->get();


        return $this->response(PurchaseOrderResource::collection($purchases));
    }


    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchase = $purchaseOrder->load(['order.warehouse', 'supplier' , 'order.orderItems.item']);

        return $this->response (new PurchaseOrderResource($purchase));
    }


    public function store(PurchaseOrderRequest $request , PurchaseOrderStoreService $orderStoreService)
    {
        $result = $orderStoreService->store($request);

        if ( $result->status == 201){

            return $this->response (
                $result->data,
                $result->message,
                $result->status,
            );
        }
        return  $this->response (
            $result->data,
            $result->message,
            $result->status,
        );
    }

    public function delete(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->order->delete();

        return $this->response (response(),'Order has been deleted successfully');
    }

    public function addBatch (BatchRequest $request ,PurchaseOrder $purchaseOrder , ItemStoreService $storeService , ItemUpdateService $updateService)
    {
        $order = $purchaseOrder->order;

        $warehouse = $order->warehouse;

        $warehouseItem = $warehouse->items()->whereIn('item_id' , $order->orderItems->pluck('item_id'))
            ->get()->keyBy('id');

        $order->orderItems()->each(function ($order_item) use ($warehouse ,$warehouseItem, $storeService ,$updateService, $request){

             $item = $warehouseItem->get($order_item->item_id);

             if ($item){

                 $updateService->updateQuantityForBatch($item , $order_item->quantity);

             }else {

                 $storeService->createItemInWarehouse($item,$warehouse->id,$request);
             }

        });
        $purchase = $order->purchaseOrder;
        $purchase->isInventoried = 1;
        $purchase->save();

         return $this->response(response(),'the batch has been added in your warehouse successfully');
    }




}
