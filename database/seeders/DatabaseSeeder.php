<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\SuperAdmin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        SuperAdmin::create([
            'name' => 'Mkdad Taleb',
            'email' => 'ma@gmail.com',
            'password' => Hash::make('password')
        ]);

       //PermissionSeeder::run();
       Admin::create([
        'name' => 'Mkdad Taleb',
        'email' => 'ma@gmail.com',
        'password' => Hash::make('password'),
        'location' => 'damas',
        'active' => true,
        'email_verified_at' => Carbon::now(),
    ]);
 }

    }



