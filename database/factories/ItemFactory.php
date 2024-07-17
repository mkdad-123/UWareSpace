<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'admin_id' => $this->faker->randomNumber(),
            'SKU' => $this->faker->word(),
            'name' => $this->faker->name(),
            'sell_price' => $this->faker->randomFloat(),
            'pur_price' => $this->faker->randomFloat(),
            'size_cubic_meters' => $this->faker->randomFloat(),
            'weight' => $this->faker->randomFloat(),
            'str_price' => $this->faker->randomFloat(),
            'total_qty' => $this->faker->randomNumber(),
            'photo' => $this->faker->word(),
            'unit' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
