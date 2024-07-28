<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\ResponseManger\OperationResult;
use Exception;
use Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

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

//    public function isValidData($data , $user)
//    {
//
//        return ($user && Hash::check($data->password , $user->password));
//    }

    protected function isValidData($data)
    {
        return auth('admin')->attempt($data) ;
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

            //$user = $this->getUser($request->email);

            if(! $token = $this->isValidData($request->all())){
               return  $this->result= new OperationResult('Unauthorized',response(),401);
            }

            if(! $this->isVerified($request->email)){
                return  $this->result= new OperationResult('Your account is not verified',response(),403);
            }

            DB::commit();

            $message = 'Login successfully';
            $this->result = new OperationResult($message,$token);

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
