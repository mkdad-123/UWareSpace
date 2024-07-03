<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Services\AdminLoginService;
use App\Services\AdminRegisterService;
use App\Traits\ResetPasswordTrait;

class AdminAuthController extends Controller
{
    use ResetPasswordTrait;

    public function register(AdminRegisterRequest $request)
    {

        $result = (new AdminRegisterService())->register($request);

        return $this->response($result->data,$result->message ,$result->status);
    }

    public function login(AdminLoginRequest $request)
    {

        $result = (new AdminLoginService())->login($request);

        return $this->response($result->data,$result->message , $result->status);
    }

    public function logout()
    {
        if (auth('admin')->user()) {
            auth('admin')->user()->token()->revoke();

            return $this->response(response(),'Logged out successfully' , 401);

        }
        return $this->response(response(),'Unauthorized' , 401);

    }
}
