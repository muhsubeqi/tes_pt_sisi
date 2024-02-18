<?php

namespace Database\Seeders;

use App\Models\MenuLevel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        User::create([
            'id_user' => 1,
            'nama_user' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'no_hp' => 1111111111,
            'wa' => 1111111111,
            'pin' => 123456,
            'create_by' => 1
        ]);

        MenuLevel::create([
            'id_level' => 1,
            'level' => 'Menu Utama'
        ]);
        MenuLevel::create([
            'id_level' => 2,
            'level' => 'Menu Sub'
        ]);
        MenuLevel::create([
            'id_level' => 3,
            'level' => 'Submenu dari Submenu'
        ]);
    }
}