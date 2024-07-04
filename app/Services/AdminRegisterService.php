<?php

namespace App\Services;

use App\Mail\SendEmailVerification;
use App\Models\Admin;
use App\Models\Phone;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    protected function generateCode($user)
    {
            $code = rand(1000,9999);

            $user->setAttribute('code',$code);

            $user->setAttribute('email_verified_at',null);

            $user->save();

            return $user;
    }

    protected function sendEmail($user)
    {
        Mail::to($user->email)->send(new SendEmailVerification($user->code,$user->name));
    }

    public function register($request)
    {
        try {

            DB::beginTransaction();

            $user = $this->store($request->except('phones'));

            $user = PhoneService::storePhones($user , $request->input('phones'));

            $user = $this->generateCode($user);

            $this->sendEmail($user);

            DB::commit();

            $token = $user->createToken('Token for a admin')->accessToken;
            $message = 'your account has been created,please check your email';
            $this->result = new OperationResult($message,$token,201);

        } catch (Exception $e) {

            DB::rollBack();
            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }
        return $this->result;
    }


}
