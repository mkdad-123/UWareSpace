<?php

namespace App\Http\Controllers\Order;

use App\Enums\SellOrderEnum;
use App\filters\SellOrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\SellOrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\WarehouseResource;
use App\Models\Client;
use App\Models\Item;
use App\Models\Order;
use App\Services\Order\SellOrderStoreService;
use Illuminate\Database\Query\Builder;
use LaravelIdea\Helper\App\Models\_IH_Warehouse_QB;
use Spatie\QueryBuilder\QueryBuilder;

class SellOrderController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $sellOrders  = $admin->load('orders.sellOrder')->orders()
            ->whereHas('sellOrder' , function ($query) {

                $query->where('status', SellOrderEnum::getStatus());
            });

        $sells = QueryBuilder::for($sellOrders)
            ->allowedFilters(SellOrderFilter::filter($admin->id))
            ->with(['sellOrder.client' ,'sellOrder.shipment' , 'warehouse'])->get();

        return $this->response(OrderResource::collection($sells));
    }


    public function show(Order $order)
    {
        $purchase = $order->load(['sellOrder.client' , 'sellOrder.shipment','warehouse' , 'orderItems.item']);

        return $this->response (new OrderResource($purchase));
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

    public function delete(Order $order)
    {
        $order->delete();

        return $this->response (response(),'Order has been deleted successfully');
    }
}
