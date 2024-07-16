<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee;
use App\Rules\ValidPhone;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
{

    public function rules(): array
    {

        $employee = $this->route('employee');
        $employeeId = $employee->id;

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:250|unique:employees,email,'.$employeeId,
            'password' => 'sometimes|nullable|string|min:8',   //same:confirm-password',
            'phones' => ['sometimes','array',new ValidPhone($employee)], // this rule checks whether phone IDs are valid for the same employee
            'phones.*.id' => 'sometimes|exists:phones,id',
            'phones.*.number' => 'required_with:phones|string|max:12',
            'role_id' => 'sometimes|exists:roles,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
