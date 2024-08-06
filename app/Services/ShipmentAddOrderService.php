<?php

namespace App\Services;

use App\Enums\SellOrderEnum;
use App\Enums\VehicleEnum;
use App\ResponseManger\OperationResult;
use App\Services\Item\ItemUpdateService;
use App\Services\Order\OrderStoreService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ShipmentAddOrderService
{

    protected OperationResult $result;

    protected $updateService;

    public function __construct(ItemUpdateService $updateService)
    {
        $this->updateService = $updateService;
    }


    protected function getItems($warehouse , $order)
    {
        return  $warehouse->items()->whereIn('item_id' , $order->orderItems->pluck('item_id'))
            ->get()->keyBy('id');
    }

    protected function getQuantities($order)
    {
        return  $order->orderItems()->pluck('quantity' , 'item_id');
    }

    protected function createMapItems($warehouse , $order)
    {
        $warehouseItems = $this->getItems($warehouse , $order);

        $orderItems = $this->getQuantities($order);

        $items = $warehouseItems->map(function ($item) use ($orderItems){
            return [
                'id' => $item->id,
                'quantity' => $orderItems->get($item->id)
            ];
        });

        return $items;
    }

    protected function updateCapacity($shipment , $percent)
    {
        $shipment->current_capacity += $percent;

        $shipment->save();
    }

    protected function storeOrder($shipment , $order)
    {
        $order->sellOrder->shipment_id = $shipment->id;
        $order->sellOrder->status = SellOrderEnum::PREPARATION;
        $order->sellOrder->save();
    }

    protected function updateQuantityWarehouse($order , $warehouse)
    {
        $warehouseItems = $this->getItems($warehouse , $order);

        $order->orderItems()->each(function ($orderItem) use ($warehouseItems)
        {

            $item = $warehouseItems->get($orderItem->item_id);

            $this->updateService->updateQuantityForSellOrder($item , $orderItem->quantity);

        });
    }

    public function activeVehicle($vehicle)
    {
        $vehicle->status = VehicleEnum::ACTIVE;

        $vehicle->save();
    }

    public function addOrderInShipment($order , $shipment)
    {

        try {

            DB::beginTransaction();

            $warehouse = $order->warehouse;

            $items = $this->createMapItems($warehouse , $order);

            $percent = (new OrderStoreService())->calculateCapacity($items->toArray() , $shipment->vehicle->size_cubic_meters);

            $capacityPercent = round(($shipment->current_capacity + $percent) , 2);

            if($capacityPercent > 100)
            {
                return $this->result = new OperationResult(
                    'The shipment capacity is not enough, the percent capacity becomes '. $capacityPercent . ' %',
                    response(),
                    400
                );
            }

            $this->updateCapacity($shipment ,$percent);

            $this->storeOrder($shipment , $order);

            $this->updateQuantityWarehouse($order , $warehouse);

            $this->activeVehicle($shipment->vehicle);

            DB::commit();

            $this->result = new OperationResult(
                'the order has been added in your shipment successfully,the percent capacity becomes '. $capacityPercent. ' %',
                response(),
                201
            );

        } catch (QueryException $e) {

             DB::rollBack();

             return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage() .' with  '. $e->getLine(), response(), 500);
    }

            return $this->result;

    }
}
