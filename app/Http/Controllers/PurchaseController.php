<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseOrderEnum;
use App\Http\Resources\OrderResource;

class PurchaseController extends Controller
{
    public function showPurchases()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $purchaseOrders  = $admin->load('orders.purchase_order')->orders();

        $purchases = $purchaseOrders->whereHas('purchase_order' , function ($query){
            $query->whereIn('status' , PurchaseOrderEnum::RECEIVED);
        })->with('purchase_order')->get();

        return $this->response (OrderResource::collection($purchases));
    }
}
