<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderChangeRequest;
use App\Models\Order;
use App\Models\Shipment;
use App\Services\Order\OrderChangeStatusService;

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

    public function changeStatusShipment($request ,Shipment $shipment)
    {
        $shipment->status = $request->input('status');
        $shipment->save();

        $shipment->sellOrders()->order
    }
}
