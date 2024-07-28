<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeLoginRequest;
use App\Models\Employee;
use App\Traits\ResetPasswordTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{
    use ResetPasswordTrait;

    public function login(EmployeeLoginRequest $request)
    {
        if(! $token = auth('employee')->attempt($request->all())){

            return  $this->response( response(),'Unauthorized',401);

        }
        return $this->response($token , 'Login successfully');

    }

    public function logout()
    {
        if (auth('employee')->user()) {
            auth()->guard('employee')->logout();

            return $this->response(response(),'Logged out successfully' , 401);
        }
        return $this->response(response(),'Unauthorized' , 401);

    }

}
