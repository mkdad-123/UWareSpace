<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{
    public function login(Request $request)
    {
        $user = Employee::whereEmail($request->email)->first();

        if(!($user && Hash::check($request->password , $user->password))){
            return response()->json([
                'data' => response(),
                'message' => 'problem'
            ]);
        }

        $token = $user->createToken('Token for a employee')->accessToken;

        return response()->json([
            'data' => $token,
            'message' => 'no problem'
        ]);
    }


}
