<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Create owner user
        User::create([
            'name' => 'Shop Owner',
            'email' => 'owner@example.com',
            'role' => 'owner',
            'password' => Hash::make('password'),
        ]);

        // Create seller user
        User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'role' => 'seller',
            'password' => Hash::make('password'),
        ]);
    }
}
