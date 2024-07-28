<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Services\Admin\AdminLoginService;
use App\Services\Admin\AdminRegisterService;
use App\Services\EmailVerificationService;
use App\Traits\ResetPasswordTrait;
use Illuminate\Http\Request;

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
            auth()->guard('admin')->logout();

            return $this->response(response(),'Logged out successfully' , 401);

        }
        return $this->response(response(),'Unauthorized' , 401);

    }

    public function verify (Request $request)
    {
        return  (new EmailVerificationService())->verify($request);


    }
}
