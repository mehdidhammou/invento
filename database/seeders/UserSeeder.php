<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count()) {
            return;
        }
        User::factory(1)->create([
            'name' => 'mahdi',
            'email' => 'mehdidhammou@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::factory(1)->create([
            'name' => 'walid',
            'email' => 'walid.kesbi@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        User::factory(1)->create([
            'name' => 'admin',
            'email' => 'admin@invento.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
