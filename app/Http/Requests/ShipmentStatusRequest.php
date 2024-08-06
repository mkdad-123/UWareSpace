<?php

namespace App\Http\Requests;

use App\Enums\ShipmentEnum;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentStatusRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'status' => ['required', 'string', 'in:' . implode(',', ShipmentEnum::getStatusForChange())]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $shipment = $this->route('shipment');
            $newStatus = $this->input('status');
            $currentStatus = $shipment->status;

            if ($newStatus === ShipmentEnum::SENDING && $currentStatus !== ShipmentEnum::PREPARATION) {
                $validator->errors()->add('status', 'Status can only be changed to "sending" if it is currently "pending".');
            } else if ($newStatus === ShipmentEnum::RECEIVED && $currentStatus !== ShipmentEnum::SENDING) {
                $validator->errors()->add('status', 'Status can only be changed to "received" if it is currently "sending".');
            }
        });
    }
}
