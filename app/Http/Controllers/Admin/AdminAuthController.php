<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Services\AdminLoginService;
use App\Services\AdminRegisterService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function register(AdminRegisterRequest $request)
    {

        $result = (new AdminRegisterService())->register($request);

        return response()->json([
            'data' => $result->data,
            'message' => $result->message,
        ],201);
    }

    public function login(AdminLoginRequest $request)
    {

            $result = (new AdminLoginService())->login($request);

            return response()->json([
                'data' => $result->data,
                'message' => $result->message
            ],$result->status);
    }

    public function logout()
    {
        if (auth('admin')->user()) {
            auth('admin')->user()->token()->revoke();

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
