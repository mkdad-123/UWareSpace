<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class BatchRequest extends FormRequest
{
    public function rules(): array
    {
        $itemIds = Item::pluck('id')->toArray();

        return [
            'items' => 'sometimes|array',
            '*' => 'required_with:items|array',
            'items.*.min_quantity' => 'required_with:id|integer|min:0',
            'items.*.available_quantity'=> 'required_with:id|integer|min:0',
            'expiration_date' => 'sometimes|date|after:today'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $order = $this->route('purchaseOrder');

            if ($order->isInventoried) {
                $validator->errors()->add('items', 'this batch has been added recently in your warehouse.');
            }
        });
    }
}
