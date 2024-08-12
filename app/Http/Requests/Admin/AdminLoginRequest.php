<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|exists:admins',
            'password' => 'required',
            'firebase_token' => 'required|unique:admins,firebase_token'
        ];
    }
}
