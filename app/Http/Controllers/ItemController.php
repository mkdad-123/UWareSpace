<?php

namespace App\Http\Controllers;

use App\filters\ItemFilter;
use App\Http\Requests\Item\ItemStoreRequest;
use App\Http\Requests\Item\ItemUpdateRequest;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Services\Item\ItemStoreService;
use App\Services\Item\ItemUpdateService;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class ItemController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?: auth('employee')->user()->admin;

        $items  = $admin->load('items')->items();

        $items = QueryBuilder::for($items)
                    ->allowedFilters(ItemFilter::filter($admin->id))->get();


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

    public function update(Item $item , ItemUpdateRequest $request , ItemUpdateService $updateService)
    {
        $result = $updateService->update($item , $request);


        if ( $result->status == 200){
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

    public function delete(Item $item)
    {
        if ($item->photo)
        {
            Storage::delete('public/'.$item->photo);
        }

        $item->delete();

        return $this->response(
            response(),
            'Item has been deleted successfully',
        );
    }

    public function search()
    {}

    public function filter()
    {
        $items = QueryBuilder::for(Item::class)
            ->allowedFilters(['unit' , 'name', 'SKU',])->get();

            return $this->response(ItemResource::collection($items));

    }
}
