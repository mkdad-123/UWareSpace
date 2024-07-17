<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseStoreRequest;
use App\Http\Requests\WarehouseUpdateRequest;
use App\Http\Resources\WarehouseResource;
use App\Models\Warehouse;
use App\Services\LocationService;
use App\Services\Warehouse\WarehouseStoreService;
use App\Services\Warehouse\WarehouseUpdateService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()->load('warehouse');

        $warehouses  = $admin->warehouses();
        //$warehouses = Warehouse::whereAdminId($adminId)->get();

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

    public function update(WarehouseUpdateRequest $request , Warehouse $warehouse , WarehouseUpdateService $updateService)
    {

        $result = $updateService->update($request,$warehouse);

        if ( $result->status == 200){

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

    public function delete(Warehouse $warehouse)
    {
        $warehouse->delete();

        return $this->response(response(),'your warehouse has been deleted successfully');
    }

}
