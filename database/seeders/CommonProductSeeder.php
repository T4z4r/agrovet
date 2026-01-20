<?php

namespace Database\Seeders;

use App\Models\CommonProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommonProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Food & Groceries
            [
                'name' => 'Maize Flour (Dona)',
                'unit' => 'kg',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 10,
                'barcode' => 'MF001',
                'description' => 'Premium maize flour for ugali - 2kg bag',
                'is_active' => true,
            ],
            [
                'name' => 'Cooking Oil (Vegetable)',
                'unit' => 'liter',
                'default_cost_price' => 3500.00,
                'default_selling_price' => 4000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 5,
                'barcode' => 'CO001',
                'description' => 'Refined vegetable cooking oil - 1 liter',
                'is_active' => true,
            ],
            [
                'name' => 'Rice (Premium)',
                'unit' => 'kg',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'RI001',
                'description' => 'Long grain premium rice - 1kg',
                'is_active' => true,
            ],

            // Beverages
            [
                'name' => 'Coca Cola 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'CC300',
                'description' => 'Coca Cola soft drink 300ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Mineral Water 500ml',
                'unit' => 'bottle',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 30,
                'barcode' => 'MW500',
                'description' => 'Dasani mineral water 500ml',
                'is_active' => true,
            ],

            // Household Items
            [
                'name' => 'OMO Washing Powder',
                'unit' => 'kg',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 5500.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 6,
                'barcode' => 'OMO001',
                'description' => 'OMO laundry detergent powder - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Jik Bleach',
                'unit' => 'liter',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 12,
                'barcode' => 'JK001',
                'description' => 'Jik household bleach - 500ml',
                'is_active' => true,
            ],

            // Personal Care
            [
                'name' => 'Colgate Toothpaste',
                'unit' => 'tube',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 15,
                'barcode' => 'CT001',
                'description' => 'Colgate triple action toothpaste - 150g',
                'is_active' => true,
            ],
            [
                'name' => 'Lux Beauty Soap',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 20,
                'barcode' => 'LX001',
                'description' => 'Lux beauty soap bar - 125g',
                'is_active' => true,
            ],

            // Electronics
            [
                'name' => 'Mobile Phone Charger',
                'unit' => 'piece',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 8,
                'barcode' => 'CH001',
                'description' => 'Universal mobile phone charger with USB cable',
                'is_active' => true,
            ],
            [
                'name' => 'Phone Screen Protector',
                'unit' => 'piece',
                'default_cost_price' => 500.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 25,
                'barcode' => 'SP001',
                'description' => 'Tempered glass screen protector for smartphones',
                'is_active' => true,
            ],

            // Textiles & Clothing
            [
                'name' => 'Kanga (Cotton)',
                'unit' => 'piece',
                'default_cost_price' => 3000.00,
                'default_selling_price' => 4000.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 10,
                'barcode' => 'KG001',
                'description' => 'Traditional cotton kanga fabric - 1.5m',
                'is_active' => true,
            ],
            [
                'name' => 'Vitenge (Printed)',
                'unit' => 'meter',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 15,
                'barcode' => 'VT001',
                'description' => 'Colorful printed vitenge fabric per meter',
                'is_active' => true,
            ],

            // Stationery
            [
                'name' => 'Exercise Book A4',
                'unit' => 'piece',
                'default_cost_price' => 400.00,
                'default_selling_price' => 600.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 30,
                'barcode' => 'EB001',
                'description' => 'Ruled exercise book A4 - 96 pages',
                'is_active' => true,
            ],
            [
                'name' => 'Bic Ballpoint Pen',
                'unit' => 'piece',
                'default_cost_price' => 200.00,
                'default_selling_price' => 300.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 50,
                'barcode' => 'BP001',
                'description' => 'Bic crystal ballpoint pen - blue ink',
                'is_active' => true,
            ],

            // Hardware & Tools
            [
                'name' => 'Nails (Assorted)',
                'unit' => 'kg',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 5,
                'barcode' => 'NL001',
                'description' => 'Assorted construction nails - 1kg pack',
                'is_active' => true,
            ],
            [
                'name' => 'Electrical Wire',
                'unit' => 'meter',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 20,
                'barcode' => 'EW001',
                'description' => 'Copper electrical wire - 1.5mm per meter',
                'is_active' => true,
            ],

            // Agricultural Products
            [
                'name' => 'Fertilizer (NPK)',
                'unit' => 'kg',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 10,
                'barcode' => 'FR001',
                'description' => 'NPK fertilizer for crops - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Maize Seeds',
                'unit' => 'kg',
                'default_cost_price' => 8000.00,
                'default_selling_price' => 10000.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 2,
                'barcode' => 'MS001',
                'description' => 'Certified maize seeds - 1kg pack',
                'is_active' => true,
            ],

            // Tobacco & Related
            [
                'name' => 'Sportsman Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 12,
                'barcode' => 'SP001',
                'description' => 'Sportsman cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            CommonProduct::create($product);
        }
    }
}