<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $adminId = auth('employee')->user()->admin_id;
        $itemId = $this->route('item')->id;

        return [
            'SKU' => 'required|string|max:255|unique:items,SKU,'.$itemId.',id,admin_id,' . $adminId,
            'name' => 'sometimes|string|max:255',
            'sell_price' => 'sometimes|numeric|min:0',
            'pur_price' => 'sometimes|numeric|min:0',
            'size_cubic_meters' => 'sometimes|numeric|min:0',
            'weight' => 'sometimes|numeric|min:0',
            'str_price' => 'sometimes|numeric|min:0',
            'total_qty'=> 'sometimes|integer|min:0',
            'photo' => 'sometimes|image|mimes:jpg,png,jpeg',
            'unit' => 'sometimes|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
