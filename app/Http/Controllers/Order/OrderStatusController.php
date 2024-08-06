<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderChangeRequest;
use App\Http\Requests\ShipmentStatusRequest;
use App\Models\Order;
use App\Models\Shipment;
use App\Services\Order\OrderChangeStatusService;
use Illuminate\Http\Request;
use Throwable;

class OrderStatusController extends Controller
{
    public function changeStatusPurchase(OrderChangeRequest $request , Order $order , OrderChangeStatusService $changeStatusService)
    {
        $result = $changeStatusService->changePurchaseStatus($request ,$order );

        if ( $result->status == 200){

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

    public function changeStatusSell(Order $order, Request $request)
    {
        $status = $request->input('status');
        $sellOrder = $order->sellOrder;
        $sellOrder->status = $status;
        $sellOrder->save();

//        if($status === SellOrderEnum::RETURNED){}

        return $this->response(response() , 'Order status has been changed successfully');

    }

    /**
     * @throws Throwable
     */
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
