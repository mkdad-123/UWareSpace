<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|unique:clients,email,'.$clientId,
            'location'=> 'sometimes|array',
            'location.country' => 'required_with:location|string|max:250',
            'location.city' => 'required_with:location|string|max:250',
            'location.region' => 'required_with:location|string|max:250',
            'location.street' => 'sometimes|string|max:250',
            'phones' => 'sometimes|array',
            'phones.*.id' => 'required_with:phones',
            'phones.*.number'=> 'required_with:phones|string',
        ];
    }
}
