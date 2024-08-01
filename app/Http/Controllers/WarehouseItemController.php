<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseItemStoreRequest;
use App\Http\Requests\WarehouseItemUpdateRequest;
use App\Http\Resources\WarehouseItemResource;
use App\Http\Resources\WarehouseResource;
use App\Models\Item;
use App\Models\Warehouse;
use App\Services\Item\ItemStoreService;
use App\Services\Item\ItemUpdateService;

class WarehouseItemController extends Controller
{
    public function store(Item $item ,WarehouseItemStoreRequest $request , ItemStoreService $storeService)
    {
        $result = $storeService->storeInWarehouse($request,$item);

        if ( $result->status == 201){

            return $this->response(
                new WarehouseResource($result->data),
                $result->message,
                $result->status,
            );
        }
        return  $this->response(
            $result->data,
            $result->message,
            $result->status,
        );
    }

    public function update(Item $item ,WarehouseItemUpdateRequest $request , ItemUpdateService $updateService)
    {
        $updateService->updateItemInWarehouse(
            $item ,
            $request->input('warehouse_id') ,
            $request->except(['warehouse_id'])
        );

        return $this->response(response(),'Items have been updated in your warehouse successfully');

    }

    public function filterMinQuantity(Warehouse $warehouse)
    {
        $items = $warehouse->items()->whereColumn('warehouse_item.real_qty' , '<=' , 'warehouse_item.min_qty' )->get();

        return $this->response(WarehouseItemResource::collection($items));
    }

}
