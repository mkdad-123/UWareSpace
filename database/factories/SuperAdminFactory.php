<?php

namespace Database\Factories;

use App\Models\SuperAdmin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class SuperAdminFactory extends Factory
{
    protected $model = SuperAdmin::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
