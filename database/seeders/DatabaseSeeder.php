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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Admin::factory(10)->create();

        //Employee::factory(10)->create();

        SuperAdmin::create([
            'name' => 'Mkdad Taleb',
            'email' => 'ma0109424@gmail.com',
            'password' => Hash::make('password')
        ]);

     //   PermissionSeeder::run();

       Admin::create([
           'name' => 'Mkdad Taleb',
           'email' => 'ma0109424@gmail.com',
           'password' => Hash::make('password'),
           'location' => 'damas',
           'active' => true,
           'email_verified_at' => Carbon::now(),
       ]);
    }


}
