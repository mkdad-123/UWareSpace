<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:suppliers,email',
            'location'=> 'required|string|max:355',
            'phones' => 'required|array',
            'phones.*.number'=> 'required|string',
        ];
    }
}
