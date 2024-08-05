<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentEnum;
use App\Http\Requests\Shipment\ShipmentStoreRequest;
use App\Http\Requests\ShipmentAddOrderRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Item;
use App\Models\Order;
use App\Models\Shipment;
use App\Services\Item\ItemUpdateService;
use App\Services\Order\OrderStoreService;
use App\Services\ShipmentAddOrderService;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $shipments  = $admin->load('shipments')->shipments();

        $shipments = $shipments->whereIn('status' , ShipmentEnum::getStatus())->get();

        return $this->response(ShipmentResource::collection($shipments));
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['warehouse' , 'vehicle' , 'employee' , 'sellOrders.client' , 'sellOrders.order.orderItems.item' ]);

        return $this->response(new ShipmentResource($shipment));
    }

    public function store(ShipmentStoreRequest $request)
    {
        Shipment::create($request->all());

        return $this->response(response() , 'Shipment has been created successfully');
    }

    public function update(Request $request , Shipment $shipment)
    {
        $shipment->fill($request->all());

        return $this->response($shipment , 'Shipment has been updated successfully');
    }

    public function delete(Shipment $shipment)
    {
        $shipment->delete();

        return $this->response($shipment , 'Shipment has been deleted successfully');
    }

    public function addOrder(Shipment $shipment ,  ShipmentAddOrderRequest $request , ShipmentAddOrderService $addOrderService)
    {
        $orderId = $request->input('order_id');

        $order = Order::find($orderId);

        $result = $addOrderService->addOrderInShipment($order , $shipment);

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

}
