<?php

namespace App\Http\Requests\Order;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use function Simplex\Tests\id;

class SellOrderStoreRequest extends FormRequest
{
    public function rules(): array
    {

        $itemIds = DB::table('warehouse_item')->where('warehouse_id' , $this->warehouse_id)
            ->pluck('item_id')->toArray();


        return [
            'warehouse_id' => ['required' , 'exists:warehouses,id'],
            'payment_type' => ['sometimes' ,'string', 'in:cash,debt'],
            'payment_at' => ['required_if:payment_type,debt' ,'date','after:today'],
            'client_id' => ['required', 'exists:clients,id'],
            'items' => ['required' , 'array'],
            'items.*.id' => ['required' , 'in:'.implode(',',$itemIds)],
            'items.*.quantity' => ['required' , 'integer' , 'min:1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        if ($validator->passes()) {
            $validator->after(function ($validator) {

                $ids = array_column($this->items, 'id');

                $quantities = DB::table('warehouse_item')->where('warehouse_id', $this->warehouse_id)
                    ->whereIn('item_id', $ids)->get(['item_id', 'available_qty'])->keyBy('item_id');

                foreach ($this->items as $item) {

                    if ($quantities[$item['id']]->available_qty < $item['quantity']) {
                        $validator->errors()->add('items.' . $item['id'] . '.quantity', 'the quantity is not available in your warehouse.');
                    }
                }
            });
        }
    }
}
