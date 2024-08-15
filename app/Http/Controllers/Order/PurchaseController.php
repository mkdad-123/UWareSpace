<?php

namespace App\Http\Controllers\Order;

use App\filters\PurchaseOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseOrderResource;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:manage purchases|manage previous purchases')->except('showNonInventoried');

        $this->middleware('permission:manage inventory')->only('showNonInventoried');
    }

    public function showPurchases()
    {

        $admin = auth('admin')->user() ?: auth('employee')->user()->admin;

        $purchaseOrders = $admin->load([
            'purchaseOrders.order.warehouse', 'purchaseOrders.supplier',
        ])->purchaseOrders()
            ->with(['order.warehouse', 'supplier'])->purchase();

        $purchases = QueryBuilder::for($purchaseOrders)
            ->allowedFilters(PurchaseOrderFilter::filterPurchase($admin->id))
            ->with(['order.warehouse', 'supplier'])->get();


        return $this->response(PurchaseOrderResource::collection($purchases));

    }

    public function showNonInventoried()
    {
        $admin = auth('admin')->user() ?: auth('employee')->user()->admin;

        $nonInventoried = $admin->load([
            'purchaseOrders.order.warehouse', 'purchaseOrders.supplier',
        ])->purchaseOrders()
            ->with(['order.warehouse', 'supplier'])->nonInventoried()->get();

        return $this->response(PurchaseOrderResource::collection($nonInventoried));
    }
}
