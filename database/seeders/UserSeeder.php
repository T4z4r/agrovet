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
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Create owner user
        User::firstOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Shop Owner',
                'role' => 'owner',
                'password' => Hash::make('password'),
            ]
        );

        // Create seller user
        User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller User',
                'role' => 'seller',
                'password' => Hash::make('password'),
            ]
        );
    }
}
