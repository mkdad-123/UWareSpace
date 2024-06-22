<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|between:10,50|unique:admins',
            'password'=> 'required|string|min:6',
            'location' => 'sometimes|string',
            'logo' => 'sometimes|string|mimes:jpg,png,jpeg'
        ];
    }
}
