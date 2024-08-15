<?php

namespace App\Services;

use App\Http\Requests\BatchRequest;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\ResponseManger\OperationResult;
use App\Services\Item\ItemStoreService;
use App\Services\Item\ItemUpdateService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BatchStoreService
{

    public OperationResult $result;

    public function __construct(
        protected ItemStoreService $storeService ,
        protected ItemUpdateService $updateService,
        protected QualityService $qualityService)
    {}

    protected function getItems($warehouse , $orderItems)
    {
        return $warehouse->items()->whereIn('item_id' , $orderItems->pluck('item_id'))
            ->get()->keyBy('id');
    }

    protected function getData($itemId , $request , $orderItem)
    {
        $data = $request->input('items')[$itemId];
        $data['real_quantity'] = $orderItem->quantity;
        return $data ;
    }


    protected function addBatchInWarehouse($order , $warehouse , $items , $request)
    {
        $order->orderItems()->each(function ($orderItem) use ($warehouse ,$items, $request)
        {

            $itemId = $orderItem->item_id;

            $item = $items->get($itemId);

            $data = $this->getData($itemId , $request , $orderItem);

            if ($item) {

                $this->updateService->updateQuantityForBatch($item , $data['real_quantity']);

            } else {
                $item = Item::find($itemId);
                $this->storeService->createItemInWarehouse($item,$warehouse->id,$data);
            }

            if (array_key_exists('expiration_date' , $data)){
                $this->qualityService->storeExpirationDate($itemId , $data , $warehouse->id);
            }
        });
    }

    protected function inventory($purchaseOrder)
    {
        $purchaseOrder->isInventoried = 1;
        $purchaseOrder->save();
    }


    public function storeBatch(BatchRequest $request , PurchaseOrder $purchaseOrder)
    {
        try {

            DB::beginTransaction();

                $order = $purchaseOrder->order;

                $warehouse = $order->warehouse;

                $warehouseItems = $this->getItems($warehouse , $order->orderItems);

                $this->addBatchInWarehouse($order , $warehouse ,$warehouseItems, $request);

                $this->inventory($purchaseOrder);


            DB::commit();

            $this->result = new OperationResult('the batch has been added in your warehouse successfully', response());

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }
        return $this->result;


    }
}
