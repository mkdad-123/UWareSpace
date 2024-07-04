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

        if($this->relationLoaded('phones'))
        {
            $data['phones'] = $this->phones->map(function ($phone){
                return [
                    'id' => $phone->id,
                    'number' => $phone->number,
                ];
            });
        };

        return $data;
    }
}
