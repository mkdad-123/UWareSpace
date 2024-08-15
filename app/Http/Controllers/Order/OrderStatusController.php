<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderChangeRequest;
use App\Http\Requests\SellOrderStatusRequest;
use App\Http\Requests\ShipmentStatusRequest;
use App\Models\PurchaseOrder;
use App\Models\SellOrder;
use App\Models\Shipment;
use App\Services\Order\OrderChangeStatusService;

class OrderStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:change status sell order|manage sells|manage current sell orders')
        ->only('changeStatusSell');

        $this->middleware('permission:manage purchases|manage current purchase orders')
            ->only('changeStatusPurchase');

        $this->middleware('permission:manage shipments')->only('changeStatusShipment');

    }

    public function changeStatusPurchase(OrderChangeRequest $request , PurchaseOrder $purchaseOrder , OrderChangeStatusService $changeStatusService)
    {
        $result = $changeStatusService->changePurchaseStatus($request ,$purchaseOrder);

            return $this->response ($result->data, $result->message, $result->status,);

    }

    public function changeStatusSell(SellOrder $sellOrder, SellOrderStatusRequest $request)
    {
        $status = $request->input('status');
        $sellOrder->status = $status;
        $sellOrder->save();

//        if($status === SellOrderEnum::RETURNED){}

        return $this->response(response() , 'Order status has been changed successfully');

    }

    public function changeStatusShipment(Shipment $shipment , ShipmentStatusRequest $request)
    {

        $status =  $request->input('status');

        if ($status == 'sending')
        {
            $shipment->status = $status;
            $shipment->save();

            $shipment->sellOrders->each(function ($sellOrder) use ($request){
                $sellOrder->status = $request->input('status');
                $sellOrder->save();
            }) ;
        }else {
            $shipment->status = $status;
            $shipment->save();
        }

        return $this->response(response() , 'Shipment status has been changed successfully');
    }

}
