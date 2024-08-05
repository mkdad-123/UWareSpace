<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|unique:suppliers,email,'.$id,
            'location'=> 'sometimes|string|max:355',
            'phones' => 'sometimes|array',
            'phones.*.id' => 'required_with:phones',
            'phones.*.number'=> 'required_with:phones|string',
        ];
    }
}
