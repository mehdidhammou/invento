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
            'total_price' => 0,
            'total_paid' => 0,
            'discount' => $this->faker->numberBetween(0, 50),
            'date' => $this->faker->date(),
            'status' => OrderStatusEnum::PENDING->name,
        ];
    }
}
