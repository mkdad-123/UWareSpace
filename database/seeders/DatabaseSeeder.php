<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         SuperAdmin::create([
            'name' => 'Mkdad Taleb',
            'email' => 'ma0109424@gmail.com',
            'password' => Hash::make('password')
        ]);

        Admin::create([
            'name' => 'Mkdad Taleb',
            'email' => 'ma0109424@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '0987654323456',
            'location' => 'damas'
        ]);
    }
}
