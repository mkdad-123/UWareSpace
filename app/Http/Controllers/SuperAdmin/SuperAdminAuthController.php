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

        $user = SuperAdmin::whereEmail($request->email)->first();

        if (!($user && Hash::check($request->password, $user->password))) {
            return response()->json([
                'data' => response(),
                'message' => 'Unauthorized',
            ],401);

        }
        $token = $user->createToken('Token name')->accessToken;

        return response()->json([
            'data' => $token,
            'message' => 'Login successful'
        ]);
    }

    public function logout()
    {
        if (auth('superAdmin')->user()) {
            auth('superAdmin')->user()->token()->revoke();

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
