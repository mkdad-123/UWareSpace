<?php

namespace App\Http\Requests;

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
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required',   //same:confirm-password',
            'phone' => 'required|max:12',
            'location' => 'sometimes',
            'role_id' => 'required|exists:roles,id'
        ];
    }
}
