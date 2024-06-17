<?php

namespace App\Http\Controllers;

use App\DTOs\AdminRegisterDto;
use App\Http\Requests\AdminRegisterRequest;
use App\Models\Admin;
use App\Services\AdminRegisterService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function register(AdminRegisterRequest $request)
    {

        $result = (new AdminRegisterService())->register($request);

        return response()->json([
            'token' => $result->data,
            'message' => $result->message,
        ],201);
    }
}
