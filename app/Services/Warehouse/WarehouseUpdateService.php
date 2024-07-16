<?php

namespace App\Services\Warehouse;

use App\ResponseManger\OperationResult;
use App\Services\LocationService;
use DB;
use Exception;
use Illuminate\Database\QueryException;

class WarehouseUpdateService
{
    protected OperationResult $result;

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    protected function updateName($request , $warehouse)
    {
        if($request->has('name')){
            $warehouse->name = $request->input('name');
        }
        return $warehouse;
    }

    protected function updateSize($request , $warehouse)
    {
        if($request->has('size_cubic_meters')){
            $warehouse->size_cubic_meters = $request->input('size_cubic_meters');

            // change current capacity for new size
        }

        return $warehouse;
    }

    protected function updateLocation($addrCoordinate , $warehouse)
    {
        $warehouse->latitude = $addrCoordinate['latitude'];
        $warehouse->longitude = $addrCoordinate['longitude'];
        $warehouse->location = $addrCoordinate['address'];

        return $warehouse;
    }

    public function update($request , $warehouse)
    {
        try {
            DB::beginTransaction();

            $warehouse = $this->updateName($request , $warehouse);

            $warehouse = $this->updateSize($request , $warehouse);

            if($request->has('location'))
            {
                if (! $addrCoordinate = $this->locationService->transformAddress($request->input('location')))
                {
                    return $this->result = new OperationResult('Failed to get coordinate',response(), 400);
                }

                $warehouse = $this->updateLocation($addrCoordinate , $warehouse);
            }
            $warehouse->save();

             DB::commit();

            $this->result = new OperationResult('Your warehouse has been updated successfully' , $warehouse,200);

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
