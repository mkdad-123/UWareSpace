<?php

namespace App\Services\Warehouse;

use App\Models\Warehouse;
use App\ResponseManger\OperationResult;
use App\Services\LocationService;
use DB;
use Mockery\Exception;

class WarehouseStoreService
{
    protected OperationResult $result;
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    protected function storeWarehouse(mixed $data)
    {
        $data['current_capacity'] = 0.00;
        $data['admin_id'] = auth('admin')->id();
        return Warehouse::create($data);

    }

    protected function getAddress($location)
    {
        return $this->locationService->transformAddress($location);
    }

    protected function mergeData($data , $adrsCoordinate)
    {
        return  array_merge($data , [
            'location' => $adrsCoordinate['address'],
            'latitude' => $adrsCoordinate['latitude'],
            'longitude' => $adrsCoordinate['longitude']
        ]);
    }

    public function store(mixed $data , $location){
        try {

            DB::beginTransaction();

            if($location){

                if(! $adrsCoordinate = $this->getAddress($location)){

                    return $this->result = new OperationResult('Failed to get coordinate',response(), 400);
                }

                $data = $this->mergeData($data ,$adrsCoordinate);
            }

            $warehouse = $this->storeWarehouse($data);

            DB::commit();

            $this->result = new OperationResult('Your warehouse has been added successfully' , $warehouse,201);

        }catch (Exception $e){

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }

        return $this->result;
    }

}
