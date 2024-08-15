<?php

namespace App\Http\Controllers\Order;

use App\filters\PurchaseOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\BatchRequest;
use App\Http\Requests\Order\PurchaseOrderRequest;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\PurchaseOrder;
use App\Services\BatchStoreService;
use App\Services\Order\PurchaseOrderStoreService;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseOrderController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('permission:manage current purchase orders|manage purchases')->except('addBatch');
//
//        $this->middleware('manage inventory')->only('addBatch');
//    }

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

        return  $this->response ($result->data, $result->message, $result->status,);

    }

    public function delete(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->order->delete();

        return $this->response (response(),'Order has been deleted successfully');
    }

    public function addBatch (BatchRequest $request ,PurchaseOrder $purchaseOrder ,BatchStoreService $batchService )
    {
        $result = $batchService->storeBatch($request , $purchaseOrder);

        return  $this->response ($result->data, $result->message, $result->status,);

    }




}
