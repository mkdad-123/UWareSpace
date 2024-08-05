<?php

namespace App\Http\Controllers\Order;

use App\Enums\SellOrderEnum;
use App\filters\SellOrderFilter;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class SellController extends Controller
{
    public function showSells()
    {

        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $purchaseOrders  = $admin->load('orders.sellOrder')->orders()
            ->whereHas('sellOrder' , function ($query) {

                $query->where('status', SellOrderEnum::RECEIVED);
            });

        $purchases = QueryBuilder::for($purchaseOrders)
            ->allowedFilters(SellOrderFilter::filter($admin->id))
            ->with(['sellOrder.client' , 'warehouse'])->get();

        return $this->response (($purchases));
    }
}
