<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first shop or create one if none exists
        $shop = Shop::first();
        if (!$shop) {
            $shop = Shop::create([
                'name' => 'Default Shop',
                'owner_id' => 1, // Assuming superadmin or owner id
                'location' => 'Default Location'
            ]);
        }

        // Create branches for the shop
        Branch::firstOrCreate(
            ['name' => 'Main Branch', 'shop_id' => $shop->id],
            ['location' => 'Main Location']
        );

        Branch::firstOrCreate(
            ['name' => 'Branch 2', 'shop_id' => $shop->id],
            ['location' => 'Branch 2 Location']
        );
    }
}