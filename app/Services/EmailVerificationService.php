<?php

namespace App\Services;

use App\Models\Admin;
use App\ResponseManger\OperationResult;
use Illuminate\Auth\Events\Verified;

class EmailVerificationService{

    protected OperationResult $result;

    protected function validData($request , $admin)
    {
        return ((
            (hash_equals((string) $admin->getKey(), (string) $request->route('id')))  &&
            (hash_equals(sha1($admin->getEmailForVerification()), (string) $request->route('hash')))
        ));
    }

    public function verify($request)
    {
        $admin = Admin::find($request->route('id'));

        if ($this->validData($request,$admin)){
            return $this->result = new OperationResult('Invalid data' , response() , 422);
        }

        if ($admin->hasVerifiedEmail()) {
            return $this->result = new OperationResult('Already success' , response() , 200);
        }

        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin));
        }

        return $this->result = new OperationResult(' success' , response() , 200);
    }
}
