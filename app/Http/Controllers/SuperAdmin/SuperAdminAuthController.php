<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use App\Traits\ResetPasswordTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class SuperAdminAuthController extends Controller
{
    use ResetPasswordTrait;

    public function login(Request $request)
    {
        if(! $token = auth('superAdmin')->attempt($request->all())){

            return  $this->response( response(),'Unauthorized',401);

        }
        return $this->response($token , 'Login successfully');
    }

    public function logout()
    {
        if (auth('superAdmin')->user()) {
            auth()->guard('superAdmin')->logout();


            return response()->json([
                'data' => response(),
                'message' => 'Logged out successfully',
            ]);
        }
        return response()->json([
            'data' => response(),
            'message' => 'Unauthorized',
        ],401);
    }
}
