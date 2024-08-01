<?php

namespace App\Http\Requests\Admin;

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins,email',
            'password'=> 'required|string|min:8',
            'location' => 'sometimes|string',
            'phones' => 'required',
            'phones.*.number'=> 'required|string',
            'logo' => 'sometimes|image|mimes:jpg,png,jpeg'
        ];
    }
}
