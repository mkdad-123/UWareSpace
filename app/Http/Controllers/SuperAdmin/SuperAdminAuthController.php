<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminAuthController extends Controller
{
    public function login(Request $request)
    {

        $user = SuperAdmin::whereEmail($request->email)->first();

        if (!($user && Hash::check($request->password, $user->password))) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ],401);

        }
        $token = $user->createToken('Token name')->accessToken;

        return response()->json([
            'status' => 200,
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }

    public function logout()
    {
        if (auth('superAdmin')->user()) {
            auth('superAdmin')->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Logged out successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'status' => 401,
            'message' => 'Unauthorized',
        ],401);
    }
}
