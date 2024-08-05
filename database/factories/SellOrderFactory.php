<?php

namespace Database\Factories;

use App\Models\SellOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SellOrderFactory extends Factory
{
    protected $model = SellOrder::class;

    public function definition(): array
    {
        return [
            'order_id' => $this->faker->randomNumber(),
            'client_id' => $this->faker->randomNumber(),
            'shipment_id' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
