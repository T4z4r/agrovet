<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Shop;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
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
        // Get the first branch
        $branch = Branch::first();

        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role'=>'admin',
                'branch_id' => null, // Superadmin not tied to branch

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
                'branch_id' => null, // Owner can access all branches

            ]
        );
        $owner->assignRole('owner');

        // Create shop for owner
        $shop = Shop::firstOrCreate(
            ['owner_id' => $owner->id],
            [
                'name' => 'Sample Shop',
                'location' => 'Nairobi, Kenya',
            ]
        );

        // Create default subscription for owner
        $freePackage = SubscriptionPackage::where('name', 'Free')->first();
        if ($freePackage) {
            Subscription::create([
                'user_id' => $owner->id,
                'shop_id' => $shop->id,
                'subscription_package_id' => $freePackage->id,
                'start_date' => now(),
                'end_date' => now()->addMonths($freePackage->duration_months),
                'status' => 'active',
            ]);
        }

        // Create seller user
        $seller = User::firstOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller User',
                'password' => Hash::make('password'),
                'branch_id' => $branch ? $branch->id : null,
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
                'branch_id' => null,
            ]
        );
        $manager->assignRole('manager');
    }
}
