<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WarehouseItemStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemId = $this->route('item')->id;

        return [

            'warehouse_id' => 'required|exists:warehouses,id',Rule::unique('warehouses_item')
                ->where(function ($query) use ($itemId){
                    return $query->where('item_id' , $itemId);
                }),
           // unique:warehouse_item,warehouse_id,NULL,id,item_id,' . $itemId,
            'min_quantity' => 'required|integer|min:0',
            'available_quantity'=> 'required|integer|min:0',
            'real_quantity' => 'required|integer|min:0',
        ];
    }
}
