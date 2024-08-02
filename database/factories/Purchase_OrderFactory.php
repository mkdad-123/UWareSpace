<?php

namespace Database\Factories;

use App\Models\Purchase_Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class Purchase_OrderFactory extends Factory
{
    protected $model = Purchase_Order::class;

    public function definition(): array
    {
        return [
            'order_id' => $this->faker->randomNumber(),
            'supplier_id' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
