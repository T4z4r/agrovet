<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Shop;

class KedrikProductSeeder extends Seeder
{
    public function run()
    {
        $shop = Shop::first(); // Assign to first shop

        $products = [
            // DRUS
            ["Bajuton wp", "500g", 5, 9000, 11000, "DRUS"],
            ["Bajuton wp", "250g", 10, 5000, 6500, "DRUS"],
            ["Bamic 2.0Ee", "100mls", 20, 3500, 5000, "DRUS"],
            ["Duduba 250Ee", "120mls", 20, 3500, 5500, "DRUS"],
            ["Bamic 250Ee", "500mls", 10, 10000, 12000, "DRUS"],
            ["Bachloroos 500Ee", "100mls", 12, 3500, 55000, "DRUS"],
            ["Bachloroos 500Ee", "500mls", 10, 10000, 11500, "DRUS"],
            ["Albaoip 100Ee", "100mls", 12, 2500, 5000, "DRUS"],
            ["Bamitraz 12.5 Ee", "100mls", 12, 2500, 5000, "DRUS"],
            ["Bagluconate", "100mls", 5, 6500, 8000, "DRUS"],
            ["Bairon", "100mls", 12, 6500, 9000, "DRUS"],
            ["Basulf 24", "100mls", 12, 5500, 7000, "DRUS"],
            ["Baoxtetra 10%", "100mls", 12, 2700, 4000, "DRUS"],
            ["Baoxtetra20%", "100mls", 12, 3700, 4500, "DRUS"],
            // MULTIVET FARM LIMITED
            ["Tylodox Extra", "100g", 10, 15000, 18000, "MULTIVET FARM LIMITED"],
            ["Introvit", "100g", 10, 7000, 10000, "MULTIVET FARM LIMITED"],
            ["Enroveto oral", "100ml", 5, 15000, 18000, "MULTIVET FARM LIMITED"],
            ["Amprolim interch", "100g", 5, 8000, 11000, "MULTIVET FARM LIMITED"],
            ["Agracox", "100g", 10, 13500, 16500, "MULTIVET FARM LIMITED"],
            ["Kepcox oral", "100ml", 3, 16000, 19000, "MULTIVET FARM LIMITED"],
            ["Macrolan inj", "100ml", 5, 10000, 13000, "MULTIVET FARM LIMITED"],
            ["Trisal", "100g", 5, 13000, 15000, "MULTIVET FARM LIMITED"],
            ["Limoxin10%", "100ml", 5, 5000, 7500, "MULTIVET FARM LIMITED"],
            ["Limoxin inj 20%", "100ml", 5, 8500, 10000, "MULTIVET FARM LIMITED"],
            ["Limoxin", "100g", 3, 13500, 15000, "MULTIVET FARM LIMITED"],
            ["Calcikel", "500ml", 5, 15500, 18000, "MULTIVET FARM LIMITED"],
            ["Genta inj", "100ml", 5, 14000, 17000, "MULTIVET FARM LIMITED"],
            ["Expert Dudu dust", "100g", 10, 2400, 4000, "MULTIVET FARM LIMITED"],
            ["Expert Dudu dust", "200g", 10, 3000, 5000, "MULTIVET FARM LIMITED"],
            // KEEN FEEDER’S
            ["DCP Powder", "1/2kg", 24, 1500, 3000, "KEEN FEEDER’S"],
            ["DCP Powder", "1 kg", 12, 2500, 4000, "KEEN FEEDER’S"],
            ["Kee Booster", "½ L", 12, 1500, 3000, "KEEN FEEDER’S"],
            ["Keen Booster", "1 L", 12, 2500, 5000, "KEEN FEEDER’S"],
            ["Glucose", "100g", 24, 900, 1500, "KEEN FEEDER’S"],
            ["Layers Premix", "2kg", 12, 2500, 3500, "KEEN FEEDER’S"],
            ["Ng’ombe mix", "2kg", 25, 1700, 2500, "KEEN FEEDER’S"],
            // FARMERS CENTRE
            ["Ampro farm (Amprolium)", "30g", 70, 2500, 5000, "FARMERS CENTRE"],
            ["Ampro farm (Amprolium)", "100g", 20, 6500, 10000, "FARMERS CENTRE"],
            ["Trima farm", "100g", 20, 7500, 10000, "FARMERS CENTRE"],
            ["Trima farm", "30g", 20, 3500, 5000, "FARMERS CENTRE"],
            ["Neoxy chick", "200g", 6, 9900, 12000, "FARMERS CENTRE"],
            ["Neoxy chick", "100g", 20, 5500, 7500, "FARMERS CENTRE"],
            ["Neoxy chick", "30g", 30, 2500, 5000, "FARMERS CENTRE"],
            ["Fluban", "100ml", 12, 6500, 8500, "FARMERS CENTRE"],
            ["Brotoost", "100g", 12, 3900, 6000, "FARMERS CENTRE"],
            ["Tylofarm", "100g", 12, 6500, 8000, "FARMERS CENTRE"],
            ["Tylofarm", "500g", 3, 29300, 33000, "FARMERS CENTRE"],
            ["Top vit", "100g", 20, 3500, 5000, "FARMERS CENTRE"],
            ["Top vit", "30g", 20, 1300, 4000, "FARMERS CENTRE"],
            ["Fluban", "50ml", 20, 3800, 5000, "FARMERS CENTRE"],
            ["Farm vita", "30g", 20, 1700, 5000, "FARMERS CENTRE"],
            ["Farm vita", "100g", 15, 3900, 18500, "FARMERS CENTRE"],
            ["Farm vita", "500g", 3, 15500, 18000, "FARMERS CENTRE"],
            ["Broboost", "500g", 3, 15500, 18000, "FARMERS CENTRE"],
            ["Lay vita", "100g", 15, 3900, 6000, "FARMERS CENTRE"],
            ["Lay vita", "500g", 3, 15500, 18000, "FARMERS CENTRE"],
            ["Lay boost", "100g", 20, 4600, 6500, "FARMERS CENTRE"],
            ["Lay boost", "500g", 3, 15600, 17500, "FARMERS CENTRE"],
            ["OTC 20%", "30g", 15, 2500, 5000, "FARMERS CENTRE"],
            ["OTC 20%", "100g", 15, 4800, 6000, "FARMERS CENTRE"],
            ["OTC 20%", "250g", 3, 10800, 13000, "FARMERS CENTRE"],
            ["Tydox", "30g", 10, 4500, 5500, "FARMERS CENTRE"],
            ["Tiamdox", "30g", 10, 5600, 7000, "FARMERS CENTRE"],
            ["Tiamdox", "100g", 10, 15500, 17500, "FARMERS CENTRE"],
            ["Pipe raz", "30g", 20, 1900, 5000, "FARMERS CENTRE"],
            ["Pipe raz", "100g", 15, 6200, 8500, "FARMERS CENTRE"],
            ["L evi farm", "30g", 10, 3500, 5000, "FARMERS CENTRE"],
            ["Albendafem 25%", "500ml", 6, 3500, 5000, "FARMERS CENTRE"],
            ["Albendafem 25%", "1L", 2, 5000, 7000, "FARMERS CENTRE"],
            ["Ivofarm", "100ml", 10, 4400, 6000, "FARMERS CENTRE"],
            ["Ivofarm Super", "50ml", 5, 5500, 7500, "FARMERS CENTRE"],
            ["Wonder Spray", "100ml", 20, 5800, 9000, "FARMERS CENTRE"],
            ["OTC 5%", "100ml", 5, 2400, 4500, "FARMERS CENTRE"],
            ["Farm vita inje", "100ml", 12, 3900, 5500, "FARMERS CENTRE"],
            ["Fan iron", "100ml", 10, 6900, 9000, "FARMERS CENTRE"],
            ["Tyloform", "100ml", 10, 7500, 10000, "FARMERS CENTRE"],
            ["Barclean", "100ml", 5, 8500, 10000, "FARMERS CENTRE"],
            ["OROMEC", "100ml", 5, 7900, 10000, "FARMERS CENTRE"],
            ["Farm base", "200g", 6, 4400, 5500, "FARMERS CENTRE"],
            ["Farm base", "400g", 5, 7200, 9000, "FARMERS CENTRE"],
            ["V-Ride", "50ml", 12, 2400, 4000, "FARMERS CENTRE"],
            ["V-Ride", "100ml", 12, 3300, 5500, "FARMERS CENTRE"],
            ["V-Ride", "500ml", 4, 11500, 11000, "FARMERS CENTRE"],
            ["Paranex", "100ml", 12, 5200, 7000, "FARMERS CENTRE"],
            ["Paranex", "250ml", 4, 10900, 12000, "FARMERS CENTRE"],
            ["Paranex", "500ml", 4, 21000, 25000, "FARMERS CENTRE"],
            ["A.powder", "25g", 12, 1300, 3000, "FARMERS CENTRE"],
            ["A.powder", "50g", 12, 2300, 4500, "FARMERS CENTRE"],
            ["A.powder", "100g", 12, 3000, 5000, "FARMERS CENTRE"],
            ["Tiktik", "199ml", 10, 4500, 6000, "FARMERS CENTRE"],
            ["Paratop", "100ml", 12, 6200, 8000, "FARMERS CENTRE"],
            ["Paratop", "500ml", 3, 28800, 3200, "FARMERS CENTRE"],
            ["Layers Premix", "500ml", 5, 2100, 4000, "FARMERS CENTRE"],
            ["Diazinon", "500g", 12, 1900, 3000, "FARMERS CENTRE"],
            ["Dimina Farm", "28ml", 5, 5300, 8000, "FARMERS CENTRE"],
            ["Drinkers", "11L", 10, 11500, 12500, "FARMERS CENTRE"],
            ["Drinkers", "6L", 10, 5500, 6500, "FARMERS CENTRE"],
            ["Drinkers", "3L", 5, 3300, 5000, "FARMERS CENTRE"],
            ["Drinkers", "1.5L", 5, 2300, 3000, "FARMERS CENTRE"],
            ["Drinkers", "75ml", 5, 2000, 2500, "FARMERS CENTRE"],
            ["Feeders", "3kg", 5, 4000, 5000, "FARMERS CENTRE"],
            ["Feeders", "6kg", 10, 6000, 7000, "FARMERS CENTRE"],
            ["Calcium tarte", "1L", 2, 9600, 12000, "FARMERS CENTRE"],
            ["Tatw moja", "200 D.S", 30, 7500, 10000, "FARMERS CENTRE"],
            // MEDINA
            ["Nooravit (vitamin)", "100ml", 10, 4000, 6000, "MEDINA"],
            ["Ivermed", "10ml", 10, 14000, 3000, "MEDINA"],
            ["Ivermed", "100ml", 10, 8000, 10000, "MEDINA"],
            ["Penstrip", "100ml", 12, 8800, 12000, "MEDINA"],
            ["Penstrip", "50ml", 10, 5500, 8000, "MEDINA"],
            ["Tylovet", "100ml", 10, 9000, 15000, "MEDINA"],
            ["Albende zole", "1L", 5, 6000, 10000, "MEDINA"],
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
                    'remarks' => 'Initial stock from seeder'
                ], [
                    'supplier_id' => null,
                    'recorded_by' => 1, // Assume user ID 1 is admin
                    'date' => now()->toDateString(),
                ]);
            }
        }
    }
}
