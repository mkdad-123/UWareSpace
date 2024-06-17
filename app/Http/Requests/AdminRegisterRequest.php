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
            'name' => 'required|string',
            'email' => 'required|string|unique:admins',
            'password'=> 'required|string',
            'location' => 'sometimes|string',
            'logo' => 'sometimes|string|mimes:png,jpeg,jpng'
        ];
    }
}
