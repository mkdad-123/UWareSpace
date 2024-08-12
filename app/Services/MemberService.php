<?php

namespace App\Services;

use App\Models\Client;
use App\ResponseManger\OperationResult;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class MemberService
{

    protected OperationResult $result;
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    protected function mergeData($data , $adrsCoordinate)
    {
        return  array_merge($data , [
            'location' => $adrsCoordinate['address'],
            'latitude' => $adrsCoordinate['latitude'],
            'longitude' => $adrsCoordinate['longitude']
        ]);
    }

    protected function storeMember($model , $data)
    {
        $admin = auth('admin')->user()?:auth('employee')->user()->admin;

        $data['admin_id'] = $admin->id;

        return $model->create($data);

    }

    protected function storePhone($user , $phones)
    {
        return PhoneService::storePhones($user , $phones);
    }

    protected function transform($location , $data)
    {
        $country = $location['country'];
        $city = $location['city'];
        $region = $location['region'];
        $address = $region . ',' . $city . ',' . $country;
        $data['location'] = $address;

        return $data;
    }

    public function storeClient($model , $data , $location , $phones)
    {
        try {

            DB::beginTransaction();

            if($location)
            {

//                if(! $adrsCoordinate = $this->locationService->transformAddress($location))
//                {
//
//                    return $this->result = new OperationResult('Failed to get coordinate',response(), 400);
//                }
//                $data = $this->mergeData($data ,$adrsCoordinate);

                $data = $this->transform($location , $data);
            }

            $user = $this->storeMember($model , $data);

            $user = $this->storePhone($user , $phones);

            DB::commit();

            $this->result = new OperationResult('Client has been added successfully' , $user,201);

        }catch (Exception $e){

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }

        return $this->result;
    }


    public function storeSupplier($model ,$data , $phones)
    {

        try {
            DB::beginTransaction();

            $user = $this->storeMember($model , $data);

            $user = $this->storePhone($user , $phones);

            DB::commit();

            $this->result = new OperationResult('Supplier has been added successfully' , $user,201);

        }catch (Exception $e){

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }

        return $this->result;

    }

    protected function updateMember($user , $data)
    {
        $user->fill($data);
        $user->save();
        return $user;
    }

    public function updateClient($user , $data , $location , $phones)
    {
        try {

            DB::beginTransaction();

            if($location){

//                if(! $adrsCoordinate = $this->locationService->transformAddress($location)){
//
//                    return $this->result = new OperationResult('Failed to get coordinate',response(), 400);
//                }
//
//                $data = $this->mergeData($data ,$adrsCoordinate);
                $data = $this->transform($location , $data);
            }

            $user = $this->updateMember($user ,$data);

            $user = (new PhoneService())->updatePhones($phones, $user);


            DB::commit();

            $this->result = new OperationResult('Client has been updated successfully' , $user,200);

        }catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }

        return $this->result;
    }


    public function updateSupplier($user ,$data , $phones)
    {

        try {
            DB::beginTransaction();

            $user = $this->updateMember($user ,$data);

            $user = (new PhoneService())->updatePhones($phones, $user);

            DB::commit();

            $this->result = new OperationResult('Supplier has been added successfully' , $user,201);

        }catch (Exception $e){

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }

        return $this->result;

    }

}
