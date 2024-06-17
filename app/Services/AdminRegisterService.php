<?php

namespace App\Services;

use App\Mail\SendEmailVerification;
use App\Models\Admin;
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
        $user = $this->model::create($data->all());

        return $user;
    }

    protected function generateCode(Admin $user)
    {
        try {

            $code = rand(1000,9999);
            $user->setAttribute('code',$code);

            $user->setAttribute('email_verified_at',null);

            $user->save();

            return $user;

        }catch (Exception $e){

            return response($e->getMessage());
        }
    }

    protected function sendEmail($user)
    {
        Mail::to($user->email)->send(new SendEmailVerification($user));
    }

    public function register($request)
    {
        try {

            DB::beginTransaction();

            $user = $this->store($request);

            $user = $this->generateCode($user);

            //$this->sendEmail($user);

            $token = $user->createToken('Token for a admin')->accessToken;
            $message = 'your account has been created,please check your email';
            $this->result = new OperationResult($token,$message);

            DB::commit();

        } catch (Exception $e) {

            DB::rollBack();
            $this->result->message = $e->getMessage();
        }
        return $this->result;
    }


}
