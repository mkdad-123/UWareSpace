<?php

namespace App\Http\Controllers\Order;

use App\Enums\SellOrderEnum;
use App\filters\SellOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\SellOrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\SellOrderResource;
use App\Http\Resources\WarehouseResource;
use App\Models\Client;
use App\Models\Item;
use App\Models\Order;
use App\Models\SellOrder;
use App\Services\Order\SellOrderStoreService;
use Illuminate\Database\Query\Builder;
use LaravelIdea\Helper\App\Models\_IH_Warehouse_QB;
use Spatie\QueryBuilder\QueryBuilder;

class SellOrderController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('permission:manage sells|manage current sell orders')->except('checkNearestWarehouse');
//
//        $this->middleware('permission:manage clients')->only('checkNearestWarehouse');
//    }

    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sellOrders  = $admin->load([
            'sellOrders.order.warehouse' , 'sellOrders.client' , 'sellOrders.shipment',
        ])->sellOrders()
            ->with(['order.warehouse' , 'client' , 'shipment'])->sellOrder();

        $sells = QueryBuilder::for($sellOrders)
            ->allowedFilters(SellOrderFilter::filter($admin->id))
            ->with(['order.warehouse' , 'client' , 'shipment'])->get();


        return $this->response (SellOrderResource::collection($sells));

    }


    public function show(SellOrder $sellOrder)
    {
        $sell = $sellOrder->load(['order.warehouse' , 'client' , 'shipment' ,'order.orderItems.item']);

        return $this->response (new SellOrderResource($sell));
    }


    public function store(SellOrderStoreRequest $request , SellOrderStoreService $orderStoreService)
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

    public function checkNearestWarehouse(Client $client)
    {
        $warehouses = $client->warehousesByDistance();

        return $this->response (WarehouseResource::collection($warehouses),'These warehouses from closest to farthest from client');
    }

    public function delete(SellOrder $sellOrder)
    {
        $sellOrder->order->delete();

        return $this->response (response(),'Order has been deleted successfully');
    }
}
