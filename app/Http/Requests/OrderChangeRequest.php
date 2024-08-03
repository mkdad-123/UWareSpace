<?php

namespace App\Http\Requests;

use App\Enums\PurchaseOrderEnum;
use Illuminate\Foundation\Http\FormRequest;

class  OrderChangeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|string|in:'.implode(',',PurchaseOrderEnum::getStatusForChange()),
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $order = $this->route('order');
            $newStatus = $this->input('status');
            $currentStatus = $order->purchase_order->status;

            if ($newStatus === 'sending' && $currentStatus !== 'pending') {
                $validator->errors()->add('status', 'Status can only be changed to "sending" if it is currently "pending".');
            }

            if ($newStatus === 'received' && $currentStatus !== 'sending') {
                $validator->errors()->add('status', 'Status can only be changed to "received" if it is currently "sending".');
            }
        });
    }
}
