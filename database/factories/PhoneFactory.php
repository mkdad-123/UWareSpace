<?php

namespace Database\Factories;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PhoneFactory extends Factory
{
    protected $model = Phone::class;

    public function definition(): array
    {
        return [
            'phoneable_type' => $this->faker->word(),
            'phoneable_id' => $this->faker->randomNumber(),
            'number' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
