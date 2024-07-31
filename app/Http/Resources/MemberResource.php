<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
             'email' => $this->email,
            'location' => $this->location,
            'phones' => PhoneResource::collection($this->whenLoaded('phones'))
        ];
    }
}
