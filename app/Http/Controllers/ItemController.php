<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Services\Item\ItemStoreService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $items  = $admin->load('items')->items;

        return $this->response(
            ItemResource::collection($items) ,
            'Your items have been get successfully'
        );
    }


    public function show(Item $item)
    {}

    public function store(ItemStoreRequest $request , ItemStoreService $storeService)
    {
        $result = $storeService->store($request);

        if ( $result->status == 201){
            return $this->response(
                new ItemResource($result->data),
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

    public function update(Item $item , ItemUpdateRequest $request)
    {
        if ($request->has('SKU')){

        }
        $item->update([
            'SKU' => $request['SKU'],
            'name' => $request['name'],
            'sell_price' => $request['sell_price'],
            'pur_price' => $request['pur_price'],
            'str_price' => $request['start_price'],
            'weight' => $request['weight'],
            'size_cubic_meters' => $request['size_cubic_meters'],
            'total_qty' => $request['total_quantity'],
            'photo' => $request['photo'],
            'unit' => $request['unit']
        ]);

        //$item->update($request->all());

        return $this->response(
            new ItemResource($item),
            'Item has been updated successfully',
        );
    }

    public function delete(Item $item)
    {

    }

    public function search()
    {

    }

    public function filter()
    {

    }
}
