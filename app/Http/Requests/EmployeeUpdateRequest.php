<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'sometimes|email|unique:employees,email',
            'password' => 'sometimes',   //same:confirm-password',
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
