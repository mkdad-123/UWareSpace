<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class AdminLoginService
{

    public OperationResult $result;


    protected function getUser($email)
    {
        return Admin::whereEmail($email)->first();
    }


    protected function isValidData($data)
    {
        return auth('admin')->attempt($data) ;
    }

    public function isVerified($user)
    {
        return $user->email_verified_at;
    }

    public function storeFirebaseToken(Admin $user , $token)
    {
        $user->firebase_token = $token;

        $user->save();
    }

    public function login($request)
    {

        try {
            DB::beginTransaction();

            $user = $this->getUser($request->email);

            if(! $token = $this->isValidData($request->except('firebase_token')))
            {
               return  $this->result= new OperationResult('Unauthorized',response(),401);
            }

            if(! $this->isVerified($user))
            {
                return  $this->result= new OperationResult('Your account is not verified',response(),403);
            }

            $this->storeFirebaseToken($user , $request->input('firebase_token'));

            DB::commit();

            $this->result = new OperationResult('Login successfully',$token);

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
