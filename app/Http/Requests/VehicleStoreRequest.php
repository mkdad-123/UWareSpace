<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'name' => 'required|string',
            'size_cubic_meters' => 'required|numeric|min:0',
            'load_capacity_kg' => 'required|numeric|min:0',
            'plate_number' => 'nullable|unique:vehicles,plate_number,NULL,id,plate_number,!NUll',
        ];
    }
}
