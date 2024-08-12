<?php

namespace App\Http\Controllers;

use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\SellOrderResource;
use App\Models\Order;


class DebtController extends Controller
{

    public function showDebtPurchase()
    {
        $admin = auth('admin')->user() ?: auth('employee')->user()->admin;

        $purchaseDebts = $admin->load([
            'purchaseOrders.order.warehouse', 'purchaseOrders.supplier',
        ])->purchaseOrders()
            ->with(['order.warehouse', 'supplier'])->purchaseDebt()->get();

        return $this->response(PurchaseOrderResource::collection($purchaseDebts));
    }

    public function showDebtSell()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sellDebts  = $admin->load([
            'sellOrders.order.warehouse' , 'sellOrders.client' , 'sellOrders.shipment',
        ])->sellOrders()
            ->with(['order.warehouse' , 'client' , 'shipment'])->sellDebt()->get();

        return $this->response (SellOrderResource::collection($sellDebts));

    }

    public function paidDebt(Order $order)
    {
        $order->payment_type = 'cash';
        $order->payment_at = null;
        $order->save();

        return $this->response(response() , 'Payment has been made successfully');
    }


}
