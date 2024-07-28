<?php

namespace App\Services;

use App\Models\Admin;
use App\ResponseManger\OperationResult;
use Illuminate\Auth\Events\Verified;

class EmailVerificationService{


    protected function validData($request , $admin)
    {
        return ((
            (hash_equals((string) $admin->getKey(), (string) $request->route('id'))) &&
            (hash_equals(sha1($admin->getEmailForVerification()), (string) $request->route('hash')))
        ));
    }

    public function verify($request)
    {
        $admin = Admin::find($request->route('id'));

        if ( ! $this->validData($request,$admin)){
            return view('auth.failedVerify');
        }

        if ($admin->hasVerifiedEmail()) {
            return view('auth.alreadyVerify');
        }

        if ($admin->markEmailAsVerified()) {
            event(new Verified($admin));
        }

        return view('auth.successVerify');
    }
}
