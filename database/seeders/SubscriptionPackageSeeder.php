<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPackage;

class SubscriptionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Free',
                'description' => 'Basic features for trial users',
                'price' => 0,
                'duration_months' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Basic',
                'description' => 'Essential features for small shops',
                'price' => 5000,
                'duration_months' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'description' => 'Advanced features for growing businesses',
                'price' => 15000,
                'duration_months' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Full suite for large operations',
                'price' => 50000,
                'duration_months' => 12,
                'is_active' => true,
            ],
        ];

        foreach ($packages as $package) {
            SubscriptionPackage::create($package);
        }
    }
}