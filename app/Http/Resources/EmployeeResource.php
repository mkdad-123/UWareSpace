<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{

    public function toArray($request): array
    {

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location
        ];

            if($this->relationLoaded('roles'))
            {
                $data['roles'] = $this->roles->map(function ($role){
                   return [
                        'id' => $role->id,
                        'name' => $role->name,
                       ];
                });
            };

        return $data;
    }
}
