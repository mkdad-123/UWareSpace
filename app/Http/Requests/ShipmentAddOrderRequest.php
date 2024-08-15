<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentAddOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_id' => 'required|exists:sell_orders,id'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
