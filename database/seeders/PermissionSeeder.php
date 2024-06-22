<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'store',
        'delete'
    ];

    public function run(): void
    {
        foreach ($this->permissions as $permission){
            Permission::create([
                'name' => $permission,
                'guard_name' => 'employee'
            ]);
        }
    }
}
