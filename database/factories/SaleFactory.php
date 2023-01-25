<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_id' => Client::pluck('id')->random(),
            'total_price' => $this->faker->numberBetween(100000, 999999),
            'total_paid' => $this->faker->numberBetween(100000, 999999),
            'discount' => $this->faker->numberBetween(0, 50),
            'date' => $this->faker->date(),
            'status' => SaleStatusEnum::UNPAID->name,
        ];
    }
}
