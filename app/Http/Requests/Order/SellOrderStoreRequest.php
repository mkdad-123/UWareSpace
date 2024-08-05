<?php

namespace App\Http\Requests\Order;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class SellOrderStoreRequest extends FormRequest
{
    public function rules(): array
    {
        $itemIds = Item::pluck('id')->toArray();

        return [
            'warehouse_id' => ['required' , 'exists:warehouses,id'],
            'payment_type' => ['sometimes' ,'string', 'in:cash,debt'],
            'payment_at' => ['required_if:payment_type,debt' ,'date','after:today'],
            'client_id' => ['required', 'exists:clients,id'],
            'shipment_id' => ['required', 'exists:shipments,id'],
            'items' => ['required' , 'array'],
            'items.*.id' => ['required' , 'in:'.implode(',',$itemIds)],
            'items.*.quantity' => ['required' , 'integer' , 'min:1'],


        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
