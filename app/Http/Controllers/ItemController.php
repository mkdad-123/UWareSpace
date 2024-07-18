<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $items  = $admin->load('items')->items;

        return $this->response(
            //WarehouseResource::collection($items) ,
            'Your items have been get successfully'
        );
    }


    public function show(Item $item)
    {
        return $this->response($item);
    }

    public function store(Request $request)
    {

    }

    public function update(Item $item , Request $request)
    {

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
