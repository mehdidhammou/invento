<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'supplier_id' => Supplier::pluck('id')->random(),
            'total_price' => $this->faker->numberBetween(100000, 999999),
            'total_paid' => $this->faker->numberBetween(100000, 999999),
            'discount' => $this->faker->numberBetween(0, 50),
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(OrderStatusEnum::values()),
        ];
    }
}
