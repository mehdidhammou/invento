<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Client::count() || Supplier::count()){
            return;
        }
        Client::factory()->count(10)->create();
        Supplier::factory()->count(10)->create();
    }
}
