<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    public function definition(): array
    {
        return [
            'warehouse_id' => $this->faker->randomNumber(),
            'employee_id' => $this->faker->randomNumber(),
            'vehicle_id' => $this->faker->randomNumber(),
            'tracking_number' => $this->faker->word(),
            'current_capacity' => $this->faker->word(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
