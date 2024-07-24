<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
{
    public function rules(): array
    {

        $adminId = auth('employee')->user()->admin_id;

        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'SKU' => 'required|string|max:255|unique:items,SKU,NULL,id,admin_id,' . $adminId,
            'name' => 'required|string|max:255',
            'sell_price' => 'required|numeric|min:0',
            'pur_price' => 'required|numeric|min:0',
            'size_cubic_meters' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'start_price' => 'nullable|numeric|min:0',
            'total_quantity'=> 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'available_quantity'=> 'required|integer|min:0',
            'real_quantity' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'unit' => 'required|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
