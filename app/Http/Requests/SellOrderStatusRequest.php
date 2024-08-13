<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellOrderStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $order = $this->route('sellOrder');
            $newStatus = $this->input('status');
            $currentStatus = $order->status;

            if ($newStatus === 'sending' && ($currentStatus !== 'preparation')) {
                $validator->errors()->add('status', 'Status can only be changed to "sending" if it is currently "pending".');
            }

            if ($newStatus === 'received' && $currentStatus !== 'sending') {
                $validator->errors()->add('status', 'Status can only be changed to "received" if it is currently "sending".');
            }
        });
    }
}
