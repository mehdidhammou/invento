<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleProduct;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SaleProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SaleProduct::factory(10)->create();
    }
}
