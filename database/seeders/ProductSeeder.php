<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ["Bajuton wp", "500g", 5, 9000, 11000],
            ["Bajuton wp", "250g", 10, 5000, 6500],
            ["Bamic 2.0Ee", "100mls", 20, 3500, 5000],
            ["Duduba 250Ee", "120mls", 20, 3500, 5500],
            ["Bamic 250Ee", "500mls", 10, 10000, 12000],
            ["Bachloroos 500Ee", "100mls", 12, 3500, 55000],
            ["Bachloroos 500Ee", "500mls", 10, 10000, 11500],
            ["Albaoip 100Ee", "100mls", 12, 2500, 5000],
            ["Bamitraz 12.5 Ee", "100mls", 12, 2500, 5000],
            ["Bagluconate", "100mls", 5, 6500, 8000],
            ["Bairon", "100mls", 12, 6500, 9000],
            ["Basulf 24", "100mls", 12, 5500, 7000],
            ["Baoxtetra 10%", "100mls", 12, 2700, 4000],
            ["Baoxtetra20%", "100mls", 12, 3700, 4500],
        ];

        foreach ($products as $p) {
            Product::create([
                'name'          => $p[0],
                'unit'          => $p[1],
                'stock'         => $p[2],
                'cost_price'    => $p[3],
                'selling_price' => $p[4],
            ]);
        }
    }
}
