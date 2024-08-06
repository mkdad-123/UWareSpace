<?php

namespace App\Http\Controllers\Order;

use App\Enums\SellOrderEnum;
use App\filters\SellOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SellOrderResource;
use Spatie\QueryBuilder\QueryBuilder;

class SellController extends Controller
{
    public function showSells()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sellOrders  = $admin->load([
            'sellOrders.order.warehouse' , 'sellOrders.client' , 'sellOrders.shipment',
        ])->sellOrders()
            ->with(['order.warehouse' , 'client' , 'shipment'])->sell();

        $sells = QueryBuilder::for($sellOrders)
            ->allowedFilters(SellOrderFilter::filterSells($admin->id))
            ->with(['order.warehouse' , 'client' , 'shipment'])->get();


        return $this->response (SellOrderResource::collection($sells));
    }
}
