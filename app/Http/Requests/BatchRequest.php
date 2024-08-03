<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'min_quantity' => 'required_with:available_quantity|integer|min:0',
            'available_quantity'=> 'required_with:real_quantity|integer|min:0',
            'real_quantity' => 'required_with:available_quantity|integer|min:0',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
