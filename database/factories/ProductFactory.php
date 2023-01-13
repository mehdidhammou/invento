<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'category_id' => Category::pluck('id')->random(),
            'total_quantity' => fake()->randomNumber(3),
        ];
    }
}
