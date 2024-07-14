<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|string|min:8',   //same:confirm-password',
            'phones' => 'required|array',
            'phones.*.number' => 'required|string|max:12',
            'location' => 'sometimes',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
