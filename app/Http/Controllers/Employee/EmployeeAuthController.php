<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Traits\ResetPasswordTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{
    use ResetPasswordTrait;

    public function login(Request $request)
    {
        $user = Employee::whereEmail($request->email)->first();

        if(!($user && Hash::check($request->password , $user->password))){
            return $this->response(response() , 'Unauthorized' , 401);
        }

        $token = $user->createToken('Token for a employee')->accessToken;
        return $this->response($token , 'Login successfully');

    }

    public function logout()
    {
        if (auth('employee')->user()) {
            auth('employee')->user()->token()->revoke();
            return $this->response(response(),'Logged out successfully' , 401);
        }
        return $this->response(response(),'Unauthorized' , 401);

    }

}
