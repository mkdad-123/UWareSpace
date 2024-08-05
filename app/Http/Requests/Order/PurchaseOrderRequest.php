<?php

namespace App\Http\Requests\Order;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
{
    public function rules(): array
    {
        $itemIds = Item::pluck('id')->toArray();

//        $warehouseItemIds = DB::table('warehouse_item')
//            ->where('warehouse_id' , $this->input('warehouse_id'))
//            ->get('item_id');

        return [
            'warehouse_id' => ['required' , 'exists:warehouses,id'],
            'payment_type' => ['sometimes' ,'string', 'in:cash,debt'],
            'payment_at' => ['required_if:payment_type,debt' ,'date','after:today'],
            'supplier_id' => ['required', 'integer' , 'exists:suppliers,id'],
            'items' => ['required' , 'array'],
            'items.*.id' => ['required' , 'in:'.implode(',',$itemIds)],
            'items.*.quantity' => ['required' , 'integer' , 'min:1']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
