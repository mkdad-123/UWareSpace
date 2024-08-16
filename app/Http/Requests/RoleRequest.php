<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminId = auth('admin')->id();

        return [
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array|exists:permissions,id',
        ];
    }
}
