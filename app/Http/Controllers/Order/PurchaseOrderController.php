<?php

namespace App\Http\Controllers\Order;

use App\Enums\PurchaseOrderEnum;
use App\filters\PurchaseOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Order\PurchaseOrderStoreService;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseOrderController extends Controller
{

    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $purchaseOrders  = $admin->load('orders.purchase_order')->orders()
            ->whereHas('purchase_order' , function ($query) {

                $query->whereIn('status', PurchaseOrderEnum::getStatus());
            });

        $purchases = QueryBuilder::for($purchaseOrders)
            ->allowedFilters(PurchaseOrderFilter::filter($admin->id))
            ->with(['purchase_order.supplier' , 'warehouse'])->get();


        return $this->response (OrderResource::collection($purchases));
    }


    public function show(Order $order)
    {
        $purchase = $order->load(['purchase_order.supplier' , 'warehouse' , 'order_items.item']);

        return $this->response (new OrderResource($purchase));
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

    public function delete(Order $order)
    {
        $order->delete();

        return $this->response (response(),'Order has been deleted successfully');
    }

    public function addBatch($request)
    {

    }




}
