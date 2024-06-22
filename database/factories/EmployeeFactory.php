<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'admin_id' => $this->faker->randomNumber(),
            'password' => bcrypt($this->faker->password()),
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'location' => $this->faker->word(),
            'active' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
