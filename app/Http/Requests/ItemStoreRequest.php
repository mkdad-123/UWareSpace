<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    public function rules(): array
    {

        $adminId = auth('employee')->user()->admin_id;

        return [
            'admin_id' => 'required|exists:admins,id',
            'SKU' => 'required|string|max:255|unique:items,SKU,NULL,id,admin_id,' . $adminId,
            'name' => 'required|string|max:255',
            'sell_price' => 'required|numeric|min:0',
            'pur_price' => 'required|numeric|min:0',
            'size_cubic_meters' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'str_price' => 'nullable|numeric|min:0',
            'total_qty' => 'required|integer|min:0',
            'photo' => 'nullable|string|max:255|mimes:jpg,png,jpeg',
            'unit' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
