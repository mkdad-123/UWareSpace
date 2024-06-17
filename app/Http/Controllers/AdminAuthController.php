<?php

namespace App\Http\Controllers;

use App\DTOs\AdminRegisterDto;
use App\Http\Requests\AdminRegisterRequest;
use App\Models\Admin;
use App\Services\AdminLoginService;
use App\Services\AdminRegisterService;
use Hash;
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

    public function login(Request $request)
    {

            $result = (new AdminLoginService())->login($request);

            return response()->json([
                'data' => $result->data,
                'message' => $result->message
            ],$result->status);

    }
}
