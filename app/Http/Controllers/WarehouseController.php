<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseStoreRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use App\Services\WarehouseStoreService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function showAll()
    {
        $adminId = auth('admin')->id();

        $warehouses = Warehouse::whereAdminId($adminId)->get();

        return $this->response(
            WarehouseResource::collection($warehouses) ,
        'Your warehouses have been get successfully'
        );
    }

    public function show(Warehouse $warehouse)
    {
        return $this->response(
            new WarehouseResource($warehouse) ,
            'Your warehouse have been got successfully'
        );
    }

    public function store(WarehouseStoreRequest $request , WarehouseStoreService $storeService)
    {
        $data = $request->except('location');
        $location = $request->input('location');

        $result = $storeService->store($data,$location);

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

    public function update(Request $request , Warehouse $warehouse)
    {
        $warehouse->name = $request->input('name');
    }

    public function delete(Warehouse $warehouse)
    {
        $warehouse->delete();

        return $this->response(response(),'your warehouse has been deleted successfully');
    }

}
