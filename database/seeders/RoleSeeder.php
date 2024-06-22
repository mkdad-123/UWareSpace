<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    private $roles = [
        'per1' => [1,2,3], // ids are for permissions to a role
        '' => []
    ];

    public function run(): void // ask from GPT
    {
        foreach ($this->roles as $roles => $permissionsId){
            $role = Role::create(['name' => $roles]);

            $permissions = Permission::query()->whereIn('id',$permissionsId);

            $role->syncPermissions($permissions);
        }
    }
}
