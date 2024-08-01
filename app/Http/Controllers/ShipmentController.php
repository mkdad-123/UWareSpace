<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentEnum;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $shipments  = $admin->load('shipments')->shipments();

        $shipments = $shipments->whereIn('status' , ShipmentEnum::getStatus())->get();

        return $this->response(ShipmentResource::collection($shipments));
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['warehouse' , 'vehicle' , 'employee']);

        return $this->response(new ShipmentResource($shipment));
    }

    public function store(ShipmentStoreRequest $request)
    {
        $shipment = Shipment::create($request->all());
        // send notification to driver
        return $this->response($shipment , 'Shipment has been created successfully');
    }

    public function update(Request $request , Shipment $shipment)
    {
        $shipment->fill($request->all());

        return $this->response($shipment , 'Shipment has been updated successfully');
    }

    public function delete(Shipment $shipment)
    {

    }

    public function addOrder(Shipment $shipment)
    {

    }

    public function filter(Shipment $shipment)
    {

    }
}
