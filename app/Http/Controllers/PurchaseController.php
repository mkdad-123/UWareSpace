<?php

namespace App\Http\Controllers;

use App\Enums\PurchaseOrderEnum;
use App\filters\PurchaseOrderFilter;
use App\Http\Resources\OrderResource;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseController extends Controller
{
    public function showPurchases()
    {

        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $purchaseOrders  = $admin->load('orders.purchase_order')->orders()
            ->whereHas('purchase_order' , function ($query) {

                $query->where('status', PurchaseOrderEnum::RECEIVED);
            });

        $purchases = QueryBuilder::for($purchaseOrders)
            ->allowedFilters(PurchaseOrderFilter::filterPurchase($admin->id))
            ->with(['purchase_order.supplier' , 'warehouse'])->get();

        return $this->response (OrderResource::collection($purchases));
    }
}
