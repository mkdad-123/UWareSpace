<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:warehouses,name',
            'size_cubic_meters' => 'required|numeric|min:0',
            'location'=> 'sometimes|array',
            'location.country' => 'required_with:location|string|max:250',
            'location.city' => 'required_with:location|string|max:250',
            'location.region' => 'required_with:location|string|max:250',
            'location.street' => 'sometimes|string|max:250'
        ];
    }
}
