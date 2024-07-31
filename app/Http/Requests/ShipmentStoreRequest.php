<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'employee_id' => 'required|integer|exists:employees,id',
        ];
    }
}
