<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderProduct;
use App\Models\SaleProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            // partners
            ClientSupplierSeeder::class,
            // inventory
            CategorySeeder::class,
            ProductSeeder::class,
            // orders
            OrderSeeder::class,
            // documents
            BLSeeder::class,
            InvoiceSeeder::class,
            // sales
        ]);
    }
}
