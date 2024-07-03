<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if($this->relationLoaded('permissions')){

            $data['permissions'] = $this->permissions->map(function ($permission){
                return [
                    'id' => $permission->id,
                    'name' => $permission->name
                ];
            });
        };

        return $data;
    }
}
