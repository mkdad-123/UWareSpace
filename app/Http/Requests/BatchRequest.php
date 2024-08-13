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
            'items.*' => 'required_with:items|array',
            'items.*.min_quantity' => 'required_with:id|integer|min:0',
            'items.*.available_quantity'=> 'required_with:id|integer|min:0',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
