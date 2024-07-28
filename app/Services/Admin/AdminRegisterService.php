<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Phone;
use App\ResponseManger\OperationResult;
use App\Services\PhoneService;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AdminRegisterService{

    protected $model;

    protected OperationResult $result;

    public function __construct()
    {
        $this->model = new Admin();
    }

    protected function store($data)
    {
        $user = $this->model->create($data);

        return $user;
    }

    protected function storePhones($user , $phones)
    {
        foreach ($phones as $phoneData){
            $phone = new Phone();

            $phone->number = $phoneData['number'];

            $user->phones()->save($phone);
        }
        return $user;
    }


    protected function sendEmail($user)
    {
        event(new Registered($user));

        //Mail::to($user->email)->send(new SendEmailVerification($user->code,$user->name));
    }

    public function register($request)
    {
        try {

            DB::beginTransaction();

            $user = $this->store($request->except('phones'));

            $user = PhoneService::storePhones($user , $request->input('phones'));

            $this->sendEmail($user);

            DB::commit();

            $message = 'your account has been created,please check your email';
            $this->result = new OperationResult($message,response(),201);

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
