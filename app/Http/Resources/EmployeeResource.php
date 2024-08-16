<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class EmployeeResource extends JsonResource
{

    public function toArray($request): array
    {

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'location' => $this->location,
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'phones' => PhoneResource::collection($this->whenLoaded('phones')),
            'complaints' => $this->whenLoaded('compliants')
        ];
        return $data;
    }
}
