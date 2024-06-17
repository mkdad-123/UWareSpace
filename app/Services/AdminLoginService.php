<?php

namespace App\Services;

use App\Models\Admin;
use App\ResponseManger\OperationResult;
use Exception;
use Hash;
use Illuminate\Support\Facades\DB;

class AdminLoginService
{
    public $model;

    public OperationResult $result;

    public function __construct()
    {
        $this->model = new Admin;
    }

    protected function getUser($email)
    {
        return Admin::whereEmail($email)->first();
    }

    public function isValidData($data , $user)
    {

        return ($user && Hash::check($data->password , $user->password));
    }

    public function isVerified($email)
    {
        $user = Admin::whereEmail($email)->first();

        return $user->email_verified_at;
    }

    public function login($request)
    {

        try {
            DB::beginTransaction();


            $user = $this->getUser($request->email);

            if(! $this->isValidData($request,$user)){
               return  $this->result= new OperationResult('Unauthorized',response(),401);
            }

            if(! $this->isVerified($request->email)){
                return  $this->result= new OperationResult('Your account is not verified',response(),403);
            }

            DB::commit();

            $token = $user->createToken('Token for a admin')->accessToken;
            $message = 'your account has been created,please check your email';
            $this->result = new OperationResult($message,$token);

        } catch (Exception $e) {

            DB::rollBack();
            $this->result = new OperationResult(null,$e->getMessage());
        }
        return $this->result;

    }
}
