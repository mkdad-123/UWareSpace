<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    static private $permissions = [
        'store',
        'delete'
    ];

    static public function run(): void
    {
        foreach (self::$permissions as $permission){
            Permission::create([
                'name' => $permission,
                'guard_name' => 'employee'
            ]);
        }
    }
}
