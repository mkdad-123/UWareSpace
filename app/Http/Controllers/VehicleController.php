<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function showAll()
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $vehicles  = $admin->load('vehicles')->vehicles;

        return $this->response($vehicles , "Vehicle has been created successfully");
    }

    public function show(Vehicle $vehicle)
    {}

    public function store(Request $request)
    {
        $vehicle = Vehicle::create($request->all());

        return $this->response($vehicle , "Vehicle has been created successfully" , 201);
    }

    public function update(Request $request , Vehicle $vehicle)
    {
        $vehicle->fill($request->all());
        $vehicle->save();

        return $this->response($vehicle , "Vehicle has been updated successfully");

    }

    public function delete(Vehicle $vehicle)
    {
        $vehicle->delete();

        return $this->response(response() , "Vehicle has been deleted successfully");

    }
}
