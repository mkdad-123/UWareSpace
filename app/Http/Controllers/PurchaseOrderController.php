<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseOrderEnum;
use App\Http\Requests\PurchaseOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\PurchaseOrderResource;
use App\Models\Order;
use App\Models\Purchase_Order;
use App\Services\PurchaseOrderStoreService;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{

    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $purchaseOrders  = $admin->load('orders.purchase_order')->orders();

        $purchases = $purchaseOrders->whereHas('purchase_order' , function ($query){
           $query->whereIn('status' , PurchaseOrderEnum::getStatus());
        })->with('purchase_order')->get();

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



    public function update(Request $request , Purchase_Order $purchase_Order)
    {

    }

    public function delete(Purchase_Order $purchase_Order)
    {

    }

    public function filterStatus()
    {

    }

    public function sort()
    {

    }

    public function search()
    {

    }


}
