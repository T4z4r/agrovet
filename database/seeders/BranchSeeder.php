<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first shop
        $shop = Shop::first();
        if (!$shop) {
            throw new \Exception('No shop found. Please ensure UserSeeder runs before BranchSeeder.');
        }

        // Create branches for the shop
        Branch::firstOrCreate(
            ['name' => 'Main Branch', 'shop_id' => $shop->id??1],
            ['location' => 'Main Location']
        );

        Branch::firstOrCreate(
            ['name' => 'Branch 2', 'shop_id' => $shop->id??1],
            ['location' => 'Branch 2 Location']
        );
    }
}