<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseItemUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'min_quantity' => 'sometimes|integer|min:0',
            'available_quantity'=> 'sometimes|integer|min:0',
            'real_quantity' => 'sometimes|integer|min:0',
        ];
    }
}
