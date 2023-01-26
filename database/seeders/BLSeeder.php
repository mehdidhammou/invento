<?php

namespace Database\Seeders;

use App\Models\BL;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(BL::count())
            return;
        BL::factory(10)->create();
    }
}
