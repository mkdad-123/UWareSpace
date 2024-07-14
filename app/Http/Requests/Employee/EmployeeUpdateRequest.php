<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'sometimes|nullable|string|min:8',   //same:confirm-password',
            'phones' => 'sometimes|array',
            'phones.*.id' => 'sometimes|exists:phones,id',
            'phones.*.number' => 'sometimes|string|max:12',
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
