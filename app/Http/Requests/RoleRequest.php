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
        $roleId = $this->route('id');
        return [
            'name' => 'required|unique:roles,name,'.$roleId,
            'permission' => 'required|array|exists:permissions,id',
        ];
    }
}
