<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Order::count()) {
            return;
        }

        Order::factory(10)->create()->each(function ($order) {
            $order->products()->attach(
                Product::inRandomOrder()->first()->id,
                [
                    'quantity' => rand(1, 5),
                    'unit_price' => rand(1, 5) * 1000,
                    'sale_price' => rand(5, 10) * 1000,
                ]
            );
        });
        // create for each order 1 to 5 products
    }
}
