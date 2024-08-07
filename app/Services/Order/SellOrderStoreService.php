<?php

namespace App\Services\Order;

use App\Models\Employee;
use App\Models\SellOrder;
use App\Models\Warehouse;
use App\Notifications\SellOrderNotification;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SellOrderStoreService extends OrderStoreService
{

    protected function storeSellOrder($orderId ,$clientId)
    {
        SellOrder::create([
            'order_id' => $orderId,
            'client_id' => $clientId,
        ]);
    }

     /*
      * send notification for add Order into shipment
      */
    protected function sendNotification($orderId , $adminId)
    {
        $users = Employee::whereAdminId($adminId)->permission('store')->get();

        Notification::send($users , new SellOrderNotification($orderId));
    }


    public function store($request): OperationResult
    {

        try {

            DB::beginTransaction();

            $warehouse = Warehouse::find($request->input('warehouse_id'));

            $items = $request->input('items');

            $percent = $this->calculateCapacity($items ,$warehouse->size_cubic_meters );

            $capacity_percent = round(($warehouse->current_capacity - $percent) , 2);

            $orderId  = $this->storeOrder($request->only(['warehouse_id' , 'payment_type' , 'payment_at']));

            $this->addCache($orderId , $percent);

            $this->storeSellOrder($orderId , $request->input('client_id') );

            $this->storeOrderItems($orderId ,$items);

            $this->sendNotification($orderId , $warehouse->admin_id);

            DB::commit();

            $this->result = new OperationResult('Order has been created successfully , the percent capacity will become '. $capacity_percent .' %' ,
                response(),
                201
            );

        } catch (QueryException $e) {

            DB::rollBack();

             $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

             $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }

        return $this->result;
    }
}
