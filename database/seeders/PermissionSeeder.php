<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    static private array $permissions = [

        'manage inventory' , 'manage warehouses' , 'manage sells' , 'manage previous sales' , 'manage current sell orders',
        'manage shipments' ,'manage purchases'  , 'manage previous purchases' , 'manage current purchase orders',
        'manage clients' , 'manage suppliers' , 'manage external members', 'manage debts', 'manage quality',
        'add order in shipment', 'create invoices' , 'change status sell order'
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
