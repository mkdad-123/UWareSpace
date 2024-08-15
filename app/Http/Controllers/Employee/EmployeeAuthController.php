<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeLoginRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Traits\ResetPasswordTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{
    use ResetPasswordTrait;

    public function login(EmployeeLoginRequest $request)
    {
        if(! $token = auth('employee')->attempt($request->except('firebase_token'))){

            return  $this->response( response(),'Unauthorized',401);

        }
        $employee = Employee::whereEmail($request->input('email'))->first();

        if (! $employee->active)
        {
            return $this->response(response() , 'Your account is pending');
        }

        $employee->firebase_token = $request->input('firebase_token');
        $employee->save();

        return $this->response([
            'token' => $token ,
            'employee' => new EmployeeResource($employee->load('roles.permissions' ))
            ], 'Login successfully');

    }

    public function logout()
    {
        if (auth('employee')->user()) {
            auth()->guard('employee')->logout();

            return $this->response(response(),'Logged out successfully' );
        }
        return $this->response(response(),'Unauthorized' , 401);

    }

}
