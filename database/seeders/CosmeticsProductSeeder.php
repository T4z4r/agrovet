<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StockTransaction;

class CosmeticsProductSeeder extends Seeder
{
    public function run()
    {
        $shop = Shop::first(); // Assign to first shop
        $products = [
            // Skincare
            ["Cetaphil Gentle Skin Cleanser", "150ml", 20, 15000, 25000, "Skincare"],
            ["Cetaphil DermaControl Oil Control", "118ml", 15, 20000, 35000, "Skincare"],
            ["Nivea Soft Cream", "200ml", 25, 8000, 15000, "Skincare"],
            ["Vaseline Petroleum Jelly", "100g", 30, 5000, 10000, "Skincare"],
            ["Ponds Cold Cream", "100g", 20, 6000, 12000, "Skincare"],
            ["Johnson's Baby Lotion", "200ml", 15, 10000, 18000, "Skincare"],
            ["Himalaya Neem Face Wash", "150ml", 18, 12000, 22000, "Skincare"],

            // Hair Care
            ["Head & Shoulders Shampoo", "400ml", 22, 15000, 28000, "Hair Care"],
            ["Pantene Pro-V Conditioner", "400ml", 20, 16000, 30000, "Hair Care"],
            ["Tresemme Hair Oil", "200ml", 25, 12000, 25000, "Hair Care"],
            ["Garnier Fructis Shampoo", "250ml", 18, 10000, 20000, "Hair Care"],
            ["Sunsilk Shampoo", "375ml", 20, 13000, 24000, "Hair Care"],
            ["Herbal Essences Shampoo", "400ml", 15, 18000, 32000, "Hair Care"],

            // Makeup
            ["Maybelline Mascara", "9.2ml", 12, 8000, 15000, "Makeup"],
            ["L'Oréal Paris Foundation", "30ml", 10, 25000, 45000, "Makeup"],
            ["Revlon Lipstick", "4.2g", 20, 12000, 22000, "Makeup"],
            ["NYX Professional Makeup Eyeshadow Palette", "4.5g", 8, 30000, 55000, "Makeup"],
            ["Rimmel London Mascara", "10ml", 15, 10000, 18000, "Makeup"],
            ["Ponds BB Cream", "30g", 18, 15000, 28000, "Makeup"],

            // Fragrances
            ["Axe Deodorant", "150ml", 25, 8000, 15000, "Fragrances"],
            ["Rexona Deodorant", "150ml", 20, 7000, 13000, "Fragrances"],
            ["Nivea Men Deodorant", "150ml", 18, 9000, 17000, "Fragrances"],
            ["Old Spice Deodorant", "150ml", 15, 10000, 18000, "Fragrances"],
            ["Dove Deodorant", "150ml", 22, 8500, 16000, "Fragrances"],
            ["Fa Deodorant", "150ml", 20, 6000, 12000, "Fragrances"],

            // Oral Care
            ["Colgate Toothpaste", "100g", 30, 3000, 6000, "Oral Care"],
            ["Sensodyne Toothpaste", "100g", 20, 8000, 15000, "Oral Care"],
            ["Oral-B Toothbrush", "1pc", 25, 5000, 10000, "Oral Care"],
            ["Listerine Mouthwash", "250ml", 15, 12000, 22000, "Oral Care"],
            ["Close Up Toothpaste", "150g", 20, 4000, 8000, "Oral Care"],

            // Hair Accessories
            ["Hair Brush", "1pc", 15, 5000, 10000, "Accessories"],
            ["Hair Clips Set", "12pcs", 20, 3000, 6000, "Accessories"],
            ["Hair Ties", "20pcs", 25, 2000, 4000, "Accessories"],
            ["Comb", "1pc", 30, 2500, 5000, "Accessories"],

            // Body Care
            ["Lux Soap", "100g", 40, 1500, 3000, "Body Care"],
            ["Dove Soap", "100g", 35, 2000, 4000, "Body Care"],
            ["Pears Soap", "125g", 25, 2500, 5000, "Body Care"],
            ["Lifebuoy Soap", "125g", 30, 1800, 3500, "Body Care"],
            ["Dettol Soap", "75g", 20, 2000, 4000, "Body Care"],
            ["Sandal Soap", "150g", 15, 3000, 6000, "Body Care"],
        ];

        foreach ($products as $p) {
            $product = Product::updateOrCreate([
                'name' => $p[0],
                'unit' => $p[1],
            ], [
                'shop_id'       => $shop ? $shop->id : null,
                'stock'         => $p[2],
                'cost_price'    => $p[3],
                'selling_price' => $p[4],
                'category'      => $p[5],
            ]);

            // Create stock transaction if stock > 0
            if ($p[2] > 0) {
                StockTransaction::updateOrCreate([
                    'shop_id' => $shop ? $shop->id : null,
                    'product_id' => $product->id,
                    'type' => 'stock_in',
                    'quantity' => $p[2],
                    'remarks' => 'Initial cosmetics stock from seeder'
                ], [
                    'supplier_id' => null,
                    'recorded_by' => 1, // Assume user ID 1 is admin
                    'date' => now()->toDateString(),
                ]);
            }
        }
    }
}
