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
        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role'=>'admin',

            ]
        );
        $superadmin->assignRole('superadmin');

        // Create owner user
        $owner = User::firstOrCreate(
            ['email' => 'owner@example.com'],
            [
                'name' => 'Shop Owner',
                'password' => Hash::make('password'),
                                'role'=>'owner',

            ]
        );
        $owner->assignRole('owner');

        // Create seller user
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller User',
                'password' => Hash::make('password'),
            ]
        );
        $seller->assignRole('seller');

        // Create manager user
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role'=>'owner',
            ]
        );
        $manager->assignRole('manager');
    }
}
