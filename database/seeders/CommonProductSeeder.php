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
            [
                'name' => 'Embassy Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3000.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 10,
                'barcode' => 'EM001',
                'description' => 'Embassy king size cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],

            // More Food & Groceries
            [
                'name' => 'Sugar (White)',
                'unit' => 'kg',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 2500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 15,
                'barcode' => 'SU001',
                'description' => 'Refined white sugar - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Salt (Table)',
                'unit' => 'kg',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 25,
                'barcode' => 'SA001',
                'description' => 'Iodized table salt - 500g',
                'is_active' => true,
            ],
            [
                'name' => 'Tea Leaves (Black)',
                'unit' => 'kg',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 5500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'TL001',
                'description' => 'Premium black tea leaves - 250g',
                'is_active' => true,
            ],
            [
                'name' => 'Coffee (Instant)',
                'unit' => 'jar',
                'default_cost_price' => 3800.00,
                'default_selling_price' => 4500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 10,
                'barcode' => 'CF001',
                'description' => 'Nescafe instant coffee - 200g jar',
                'is_active' => true,
            ],
            [
                'name' => 'Bread (White)',
                'unit' => 'loaf',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 20,
                'barcode' => 'BR001',
                'description' => 'Fresh white bread loaf - 400g',
                'is_active' => true,
            ],
            [
                'name' => 'Milk (UHT)',
                'unit' => 'liter',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 12,
                'barcode' => 'MK001',
                'description' => 'UHT full cream milk - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Eggs (Fresh)',
                'unit' => 'dozen',
                'default_cost_price' => 3000.00,
                'default_selling_price' => 4000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 5,
                'barcode' => 'EG001',
                'description' => 'Fresh chicken eggs - 1 dozen',
                'is_active' => true,
            ],
            [
                'name' => 'Tomatoes (Fresh)',
                'unit' => 'kg',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 15,
                'barcode' => 'TM001',
                'description' => 'Fresh ripe tomatoes - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Onions (Red)',
                'unit' => 'kg',
                'default_cost_price' => 600.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 20,
                'barcode' => 'ON001',
                'description' => 'Fresh red onions - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Potatoes',
                'unit' => 'kg',
                'default_cost_price' => 400.00,
                'default_selling_price' => 700.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 25,
                'barcode' => 'PT001',
                'description' => 'Fresh potatoes - 1kg',
                'is_active' => true,
            ],

            // More Beverages
            [
                'name' => 'Sprite 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'SP300',
                'description' => 'Sprite lemon-lime soda 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Fanta Orange 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'FO300',
                'description' => 'Fanta orange soda 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Pepsi 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 750.00,
                'default_selling_price' => 950.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'PE300',
                'description' => 'Pepsi cola 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Mountain Dew 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 20,
                'barcode' => 'MD300',
                'description' => 'Mountain Dew energy drink 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Krest Bitter Lemon 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 700.00,
                'default_selling_price' => 900.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 18,
                'barcode' => 'KL300',
                'description' => 'Krest bitter lemon soda 300ml',
                'is_active' => true,
            ],

            // More Household Items
            [
                'name' => 'Ariel Washing Powder',
                'unit' => 'kg',
                'default_cost_price' => 5200.00,
                'default_selling_price' => 6200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 5,
                'barcode' => 'AR001',
                'description' => 'Ariel automatic washing powder - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Sunlight Dish Soap',
                'unit' => 'bottle',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 15,
                'barcode' => 'SL001',
                'description' => 'Sunlight dishwashing liquid - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Harpic Toilet Cleaner',
                'unit' => 'bottle',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 8,
                'barcode' => 'HP001',
                'description' => 'Harpic toilet cleaner - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Air Freshener (Glade)',
                'unit' => 'can',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 2800.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 10,
                'barcode' => 'AF001',
                'description' => 'Glade air freshener spray - 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Sponge (Scrub)',
                'unit' => 'piece',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 30,
                'barcode' => 'SC001',
                'description' => 'Kitchen scrubbing sponge',
                'is_active' => true,
            ],

            // More Personal Care
            [
                'name' => 'Close Up Toothpaste',
                'unit' => 'tube',
                'default_cost_price' => 1600.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 18,
                'barcode' => 'CU001',
                'description' => 'Close Up red hot toothpaste - 150g',
                'is_active' => true,
            ],
            [
                'name' => 'Pepsodent Toothpaste',
                'unit' => 'tube',
                'default_cost_price' => 1400.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 20,
                'barcode' => 'PD001',
                'description' => 'Pepsodent germi check toothpaste - 150g',
                'is_active' => true,
            ],
            [
                'name' => 'Lifebuoy Soap',
                'unit' => 'piece',
                'default_cost_price' => 600.00,
                'default_selling_price' => 800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 25,
                'barcode' => 'LB001',
                'description' => 'Lifebuoy total protection soap - 125g',
                'is_active' => true,
            ],
            [
                'name' => 'Dove Soap',
                'unit' => 'piece',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 15,
                'barcode' => 'DV001',
                'description' => 'Dove beauty bar soap - 135g',
                'is_active' => true,
            ],
            [
                'name' => 'Head & Shoulders Shampoo',
                'unit' => 'bottle',
                'default_cost_price' => 4200.00,
                'default_selling_price' => 5200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 10,
                'barcode' => 'HS001',
                'description' => 'Head & Shoulders anti-dandruff shampoo - 340ml',
                'is_active' => true,
            ],
            [
                'name' => 'Vaseline Body Lotion',
                'unit' => 'bottle',
                'default_cost_price' => 3800.00,
                'default_selling_price' => 4800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 12,
                'barcode' => 'VL001',
                'description' => 'Vaseline intensive care body lotion - 400ml',
                'is_active' => true,
            ],
            [
                'name' => 'Gillette Razor',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 20,
                'barcode' => 'GR001',
                'description' => 'Gillette mach3 razor blade',
                'is_active' => true,
            ],

            // More Electronics
            [
                'name' => 'Samsung Memory Card 16GB',
                'unit' => 'piece',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 6000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 6,
                'barcode' => 'MC016',
                'description' => 'Samsung microSD memory card 16GB class 10',
                'is_active' => true,
            ],
            [
                'name' => 'Power Bank 10000mAh',
                'unit' => 'piece',
                'default_cost_price' => 8500.00,
                'default_selling_price' => 12000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 4,
                'barcode' => 'PB001',
                'description' => 'Portable power bank 10000mAh with dual USB',
                'is_active' => true,
            ],
            [
                'name' => 'Earphones (Wired)',
                'unit' => 'piece',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 15,
                'barcode' => 'EP001',
                'description' => 'Basic wired earphones with mic',
                'is_active' => true,
            ],
            [
                'name' => 'Phone Case (Silicone)',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 20,
                'barcode' => 'PC001',
                'description' => 'Silicone phone case for Samsung/Android phones',
                'is_active' => true,
            ],
            [
                'name' => 'USB Cable (Android)',
                'unit' => 'piece',
                'default_cost_price' => 600.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 25,
                'barcode' => 'UC001',
                'description' => 'Micro USB charging cable - 1 meter',
                'is_active' => true,
            ],

            // More Textiles & Clothing
            [
                'name' => 'Kitenge (African Print)',
                'unit' => 'meter',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 12,
                'barcode' => 'KT001',
                'description' => 'Colorful kitenge African print fabric per meter',
                'is_active' => true,
            ],
            [
                'name' => 'Cotton Thread',
                'unit' => 'spool',
                'default_cost_price' => 200.00,
                'default_selling_price' => 400.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 40,
                'barcode' => 'TH001',
                'description' => 'Cotton sewing thread - assorted colors',
                'is_active' => true,
            ],
            [
                'name' => 'Needles (Assorted)',
                'unit' => 'pack',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 30,
                'barcode' => 'ND001',
                'description' => 'Assorted sewing needles pack',
                'is_active' => true,
            ],

            // More Stationery
            [
                'name' => 'HB Pencil',
                'unit' => 'piece',
                'default_cost_price' => 100.00,
                'default_selling_price' => 200.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 50,
                'barcode' => 'PN001',
                'description' => 'HB writing pencil',
                'is_active' => true,
            ],
            [
                'name' => 'Eraser (Large)',
                'unit' => 'piece',
                'default_cost_price' => 150.00,
                'default_selling_price' => 250.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 40,
                'barcode' => 'ER001',
                'description' => 'Large pink eraser',
                'is_active' => true,
            ],
            [
                'name' => 'Sharpener (Metal)',
                'unit' => 'piece',
                'default_cost_price' => 200.00,
                'default_selling_price' => 350.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 35,
                'barcode' => 'SH001',
                'description' => 'Metal pencil sharpener',
                'is_active' => true,
            ],
            [
                'name' => 'Ruler (30cm)',
                'unit' => 'piece',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 25,
                'barcode' => 'RL001',
                'description' => 'Plastic ruler 30cm',
                'is_active' => true,
            ],
            [
                'name' => 'Glue Stick',
                'unit' => 'piece',
                'default_cost_price' => 400.00,
                'default_selling_price' => 600.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 30,
                'barcode' => 'GS001',
                'description' => 'Pritt glue stick - 43g',
                'is_active' => true,
            ],
            [
                'name' => 'Color Pencils (12 pack)',
                'unit' => 'pack',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 15,
                'barcode' => 'CP001',
                'description' => 'Faber-Castell color pencils - 12 colors',
                'is_active' => true,
            ],

            // More Hardware & Tools
            [
                'name' => 'Hammer (Claw)',
                'unit' => 'piece',
                'default_cost_price' => 3500.00,
                'default_selling_price' => 5000.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 3,
                'barcode' => 'HM001',
                'description' => '16oz claw hammer',
                'is_active' => true,
            ],
            [
                'name' => 'Screwdriver Set',
                'unit' => 'set',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 4200.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 5,
                'barcode' => 'SD001',
                'description' => '6-piece screwdriver set',
                'is_active' => true,
            ],
            [
                'name' => 'Paint Brush (2 inch)',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 12,
                'barcode' => 'PB001',
                'description' => 'Synthetic paint brush 2 inch',
                'is_active' => true,
            ],
            [
                'name' => 'Padlock (Brass)',
                'unit' => 'piece',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 10,
                'barcode' => 'PL001',
                'description' => 'Brass padlock with 2 keys - 50mm',
                'is_active' => true,
            ],
            [
                'name' => 'Light Bulb (LED)',
                'unit' => 'piece',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 15,
                'barcode' => 'LB001',
                'description' => '9W LED light bulb - cool white',
                'is_active' => true,
            ],

            // More Agricultural Products
            [
                'name' => 'Pesticide (Insecticide)',
                'unit' => 'liter',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 6000.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 6,
                'barcode' => 'PS001',
                'description' => 'Agricultural insecticide - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Bean Seeds',
                'unit' => 'kg',
                'default_cost_price' => 5500.00,
                'default_selling_price' => 7500.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 3,
                'barcode' => 'BS001',
                'description' => 'Certified bean seeds - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Rice Seeds',
                'unit' => 'kg',
                'default_cost_price' => 4200.00,
                'default_selling_price' => 5800.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 4,
                'barcode' => 'RS001',
                'description' => 'Certified rice seeds - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Chicken Feed',
                'unit' => 'kg',
                'default_cost_price' => 1600.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 20,
                'barcode' => 'CF001',
                'description' => 'Poultry feed for layers - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Fish Feed',
                'unit' => 'kg',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 10,
                'barcode' => 'FF001',
                'description' => 'Floating fish feed - 1kg',
                'is_active' => true,
            ],

            // More Tobacco & Related
            [
                'name' => 'Dunhill Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 3200.00,
                'default_selling_price' => 3800.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 8,
                'barcode' => 'DH001',
                'description' => 'Dunhill fine cut cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
            [
                'name' => 'Marlboro Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3400.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 10,
                'barcode' => 'MB001',
                'description' => 'Marlboro red cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
            [
                'name' => 'Rolling Tobacco',
                'unit' => 'pack',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 15,
                'barcode' => 'RT001',
                'description' => 'Rolling tobacco - 50g pack',
                'is_active' => true,
            ],

            // Additional Food & Groceries
            [
                'name' => 'Wheat Flour',
                'unit' => 'kg',
                'default_cost_price' => 1600.00,
                'default_selling_price' => 1900.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 12,
                'barcode' => 'WF001',
                'description' => 'Premium wheat flour for baking - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Cooking Oil (Palm)',
                'unit' => 'liter',
                'default_cost_price' => 3200.00,
                'default_selling_price' => 3800.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 6,
                'barcode' => 'PO001',
                'description' => 'Refined palm cooking oil - 1 liter',
                'is_active' => true,
            ],
            [
                'name' => 'Soy Sauce',
                'unit' => 'bottle',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1600.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 18,
                'barcode' => 'SS001',
                'description' => 'Dark soy sauce - 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Tomato Sauce',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 20,
                'barcode' => 'TS001',
                'description' => 'Tomato ketchup - 400g',
                'is_active' => true,
            ],
            [
                'name' => 'Spaghetti',
                'unit' => 'pack',
                'default_cost_price' => 600.00,
                'default_selling_price' => 900.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 25,
                'barcode' => 'SP001',
                'description' => 'Spaghetti pasta - 500g pack',
                'is_active' => true,
            ],
            [
                'name' => 'Canned Beans',
                'unit' => 'can',
                'default_cost_price' => 1000.00,
                'default_selling_price' => 1400.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 15,
                'barcode' => 'CB001',
                'description' => 'Baked beans in tomato sauce - 400g can',
                'is_active' => true,
            ],
            [
                'name' => 'Canned Tuna',
                'unit' => 'can',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 12,
                'barcode' => 'CT001',
                'description' => 'Tuna chunks in oil - 185g can',
                'is_active' => true,
            ],
            [
                'name' => 'Peanut Butter',
                'unit' => 'jar',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3600.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 10,
                'barcode' => 'PB001',
                'description' => 'Smooth peanut butter - 375g jar',
                'is_active' => true,
            ],
            [
                'name' => 'Honey',
                'unit' => 'jar',
                'default_cost_price' => 3500.00,
                'default_selling_price' => 4500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'HN001',
                'description' => 'Pure natural honey - 500g jar',
                'is_active' => true,
            ],

            // Additional Beverages
            [
                'name' => 'Stoney Tangawizi 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 20,
                'barcode' => 'ST300',
                'description' => 'Stoney ginger beer 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Mirinda Orange 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 20,
                'barcode' => 'MO300',
                'description' => 'Mirinda orange soda 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Red Bull Energy Drink',
                'unit' => 'can',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 15,
                'barcode' => 'RB001',
                'description' => 'Red Bull energy drink 250ml can',
                'is_active' => true,
            ],
            [
                'name' => 'Tusker Lager Beer',
                'unit' => 'bottle',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1600.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'TB001',
                'description' => 'Tusker lager beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Keringet Tea',
                'unit' => 'pack',
                'default_cost_price' => 200.00,
                'default_selling_price' => 300.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 50,
                'barcode' => 'KT001',
                'description' => 'Keringet milk tea bags - 25 bags',
                'is_active' => true,
            ],

            // Additional Household Items
            [
                'name' => 'Fairy Dish Soap',
                'unit' => 'bottle',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 2800.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 12,
                'barcode' => 'FY001',
                'description' => 'Fairy platinum dishwashing liquid - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Domestos Bleach',
                'unit' => 'bottle',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 1900.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 14,
                'barcode' => 'DM001',
                'description' => 'Domestos thick bleach - 750ml',
                'is_active' => true,
            ],
            [
                'name' => 'Mr. Muscle Oven Cleaner',
                'unit' => 'can',
                'default_cost_price' => 3200.00,
                'default_selling_price' => 4000.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 8,
                'barcode' => 'MM001',
                'description' => 'Mr. Muscle oven cleaner spray - 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Dustbin (Plastic)',
                'unit' => 'piece',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 6,
                'barcode' => 'DB001',
                'description' => 'Plastic dustbin with lid - 20 liter',
                'is_active' => true,
            ],
            [
                'name' => 'Broom (Plastic)',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 15,
                'barcode' => 'BR001',
                'description' => 'Plastic broom with handle',
                'is_active' => true,
            ],
            [
                'name' => 'Mop (Cotton)',
                'unit' => 'piece',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 10,
                'barcode' => 'MP001',
                'description' => 'Cotton mop with plastic handle',
                'is_active' => true,
            ],

            // Additional Personal Care
            [
                'name' => 'Nivea Body Cream',
                'unit' => 'tube',
                'default_cost_price' => 4200.00,
                'default_selling_price' => 5200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 8,
                'barcode' => 'NV001',
                'description' => 'Nivea soft cream - 200ml',
                'is_active' => true,
            ],
            [
                'name' => 'Johnson\'s Baby Soap',
                'unit' => 'piece',
                'default_cost_price' => 900.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 18,
                'barcode' => 'JB001',
                'description' => 'Johnson\'s baby soap - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Oral B Toothbrush',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 20,
                'barcode' => 'OB001',
                'description' => 'Oral B medium toothbrush',
                'is_active' => true,
            ],
            [
                'name' => 'Axe Deodorant',
                'unit' => 'can',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 2800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 12,
                'barcode' => 'AX001',
                'description' => 'Axe dark temptation deodorant - 150ml',
                'is_active' => true,
            ],
            [
                'name' => 'Pantene Shampoo',
                'unit' => 'bottle',
                'default_cost_price' => 3800.00,
                'default_selling_price' => 4800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 10,
                'barcode' => 'PT001',
                'description' => 'Pantene pro-v smooth & silky shampoo - 340ml',
                'is_active' => true,
            ],
            [
                'name' => 'Always Sanitary Pads',
                'unit' => 'pack',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2400.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 15,
                'barcode' => 'AL001',
                'description' => 'Always ultra thin sanitary pads - 20 pads',
                'is_active' => true,
            ],

            // Additional Electronics
            [
                'name' => 'Samsung Memory Card 32GB',
                'unit' => 'piece',
                'default_cost_price' => 6500.00,
                'default_selling_price' => 8500.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 5,
                'barcode' => 'MC032',
                'description' => 'Samsung microSD memory card 32GB class 10',
                'is_active' => true,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'unit' => 'piece',
                'default_cost_price' => 5800.00,
                'default_selling_price' => 8000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 6,
                'barcode' => 'BS001',
                'description' => 'Portable Bluetooth speaker with aux input',
                'is_active' => true,
            ],
            [
                'name' => 'Selfie Stick',
                'unit' => 'piece',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 12,
                'barcode' => 'SS001',
                'description' => 'Extendable selfie stick with bluetooth remote',
                'is_active' => true,
            ],
            [
                'name' => 'Phone Stand (Adjustable)',
                'unit' => 'piece',
                'default_cost_price' => 600.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 18,
                'barcode' => 'PS001',
                'description' => 'Adjustable aluminum phone stand holder',
                'is_active' => true,
            ],

            // More Food & Groceries (reaching 100+ total)
            [
                'name' => 'Green Bananas',
                'unit' => 'kg',
                'default_cost_price' => 600.00,
                'default_selling_price' => 900.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 20,
                'barcode' => 'GB001',
                'description' => 'Fresh green bananas (ndizi mbichi) - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Cassava Flour (Unga wa Muhogo)',
                'unit' => 'kg',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 15,
                'barcode' => 'CF001',
                'description' => 'Cassava flour for ugali - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Groundnuts (Roasted)',
                'unit' => 'kg',
                'default_cost_price' => 3500.00,
                'default_selling_price' => 4500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'GN001',
                'description' => 'Roasted groundnuts (karanga) - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Simsim (Sesame Seeds)',
                'unit' => 'kg',
                'default_cost_price' => 4200.00,
                'default_selling_price' => 5500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 6,
                'barcode' => 'SS001',
                'description' => 'White sesame seeds - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Millet Flour',
                'unit' => 'kg',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 12,
                'barcode' => 'MF002',
                'description' => 'Millet flour for traditional dishes - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Sorghum Flour',
                'unit' => 'kg',
                'default_cost_price' => 1600.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 12,
                'barcode' => 'SF001',
                'description' => 'Sorghum flour - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Dried Fish (Dagaa)',
                'unit' => 'kg',
                'default_cost_price' => 4800.00,
                'default_selling_price' => 6200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 5,
                'barcode' => 'DF001',
                'description' => 'Dried dagaa fish - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Coconut Oil',
                'unit' => 'liter',
                'default_cost_price' => 5800.00,
                'default_selling_price' => 7200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 4,
                'barcode' => 'CO002',
                'description' => 'Virgin coconut oil - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Black Tea (Local)',
                'unit' => 'kg',
                'default_cost_price' => 3800.00,
                'default_selling_price' => 4800.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'BT001',
                'description' => 'Local black tea leaves - 250g',
                'is_active' => true,
            ],
            [
                'name' => 'Cardamom',
                'unit' => 'kg',
                'default_cost_price' => 8500.00,
                'default_selling_price' => 10500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 3,
                'barcode' => 'CD001',
                'description' => 'Whole cardamom pods - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Cinnamon Sticks',
                'unit' => 'kg',
                'default_cost_price' => 7200.00,
                'default_selling_price' => 9200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 4,
                'barcode' => 'CS001',
                'description' => 'Ceylon cinnamon sticks - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Cloves',
                'unit' => 'kg',
                'default_cost_price' => 9500.00,
                'default_selling_price' => 12000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 2,
                'barcode' => 'CL001',
                'description' => 'Whole cloves - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Turmeric Powder',
                'unit' => 'kg',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3800.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 10,
                'barcode' => 'TP001',
                'description' => 'Ground turmeric powder - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Cumin Seeds',
                'unit' => 'kg',
                'default_cost_price' => 4200.00,
                'default_selling_price' => 5500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 6,
                'barcode' => 'CU001',
                'description' => 'Whole cumin seeds - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Mustard Seeds',
                'unit' => 'kg',
                'default_cost_price' => 3200.00,
                'default_selling_price' => 4200.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'MS001',
                'description' => 'Yellow mustard seeds - 100g',
                'is_active' => true,
            ],
            [
                'name' => 'Popcorn Kernels',
                'unit' => 'kg',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 3000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 12,
                'barcode' => 'PK001',
                'description' => 'White popcorn kernels - 500g',
                'is_active' => true,
            ],
            [
                'name' => 'Dried Mango Slices',
                'unit' => 'kg',
                'default_cost_price' => 3800.00,
                'default_selling_price' => 5000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 8,
                'barcode' => 'DM001',
                'description' => 'Dried mango slices - 250g',
                'is_active' => true,
            ],
            [
                'name' => 'Cashew Nuts',
                'unit' => 'kg',
                'default_cost_price' => 8500.00,
                'default_selling_price' => 11000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 4,
                'barcode' => 'CN001',
                'description' => 'Raw cashew nuts - 500g',
                'is_active' => true,
            ],
            [
                'name' => 'Macadamia Nuts',
                'unit' => 'kg',
                'default_cost_price' => 12000.00,
                'default_selling_price' => 15000.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 3,
                'barcode' => 'MN001',
                'description' => 'Raw macadamia nuts - 250g',
                'is_active' => true,
            ],
            [
                'name' => 'Sunflower Seeds',
                'unit' => 'kg',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3500.00,
                'common_category_id' => 1, // Food & Groceries
                'default_minimum_quantity' => 10,
                'barcode' => 'SFS001',
                'description' => 'Sunflower seeds - 500g',
                'is_active' => true,
            ],

            // More Beverages
            [
                'name' => 'Apple Sidra 300ml',
                'unit' => 'bottle',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 18,
                'barcode' => 'AS300',
                'description' => 'Apple Sidra apple soda 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Guiness Small Malta',
                'unit' => 'bottle',
                'default_cost_price' => 600.00,
                'default_selling_price' => 800.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'GM001',
                'description' => 'Guiness Malta drink 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Alvaro Beer',
                'unit' => 'bottle',
                'default_cost_price' => 1000.00,
                'default_selling_price' => 1300.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'AB001',
                'description' => 'Alvaro pilsner beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Kilimanjaro Beer',
                'unit' => 'bottle',
                'default_cost_price' => 1100.00,
                'default_selling_price' => 1400.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'KB001',
                'description' => 'Kilimanjaro premium lager 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Safari Lager',
                'unit' => 'bottle',
                'default_cost_price' => 950.00,
                'default_selling_price' => 1250.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'SB001',
                'description' => 'Safari lager beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Nile Special Beer',
                'unit' => 'bottle',
                'default_cost_price' => 900.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 24,
                'barcode' => 'NS001',
                'description' => 'Nile Special lager 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Castle Lager',
                'unit' => 'bottle',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1500.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 20,
                'barcode' => 'CL001',
                'description' => 'Castle lager beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Heineken Beer',
                'unit' => 'bottle',
                'default_cost_price' => 1400.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 18,
                'barcode' => 'HB001',
                'description' => 'Heineken lager beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Amstel Beer',
                'unit' => 'bottle',
                'default_cost_price' => 1300.00,
                'default_selling_price' => 1700.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 18,
                'barcode' => 'AMB001',
                'description' => 'Amstel lager beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Windhoek Lager',
                'unit' => 'bottle',
                'default_cost_price' => 1250.00,
                'default_selling_price' => 1600.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 20,
                'barcode' => 'WL001',
                'description' => 'Windhoek lager beer 500ml bottle',
                'is_active' => true,
            ],
            [
                'name' => 'Black Label Beer',
                'unit' => 'bottle',
                'default_cost_price' => 1350.00,
                'default_selling_price' => 1750.00,
                'common_category_id' => 2, // Beverages
                'default_minimum_quantity' => 18,
                'barcode' => 'BL001',
                'description' => 'Carling Black Label beer 500ml bottle',
                'is_active' => true,
            ],

            // More Household Items
            [
                'name' => 'Surf Washing Powder',
                'unit' => 'kg',
                'default_cost_price' => 4800.00,
                'default_selling_price' => 5800.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 6,
                'barcode' => 'SF001',
                'description' => 'Surf excel washing powder - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Comfort Fabric Softener',
                'unit' => 'bottle',
                'default_cost_price' => 3200.00,
                'default_selling_price' => 4200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 8,
                'barcode' => 'CF001',
                'description' => 'Comfort fabric softener - 800ml',
                'is_active' => true,
            ],
            [
                'name' => 'Cif Cream Cleaner',
                'unit' => 'tube',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 10,
                'barcode' => 'CC001',
                'description' => 'Cif cream cleaner - 500g',
                'is_active' => true,
            ],
            [
                'name' => 'Raid Mosquito Coil',
                'unit' => 'pack',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 20,
                'barcode' => 'RC001',
                'description' => 'Raid mosquito coils - 10 coils per pack',
                'is_active' => true,
            ],
            [
                'name' => ' Mortein Mosquito Spray',
                'unit' => 'can',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 3000.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 12,
                'barcode' => 'MS001',
                'description' => 'Mortein mosquito spray - 300ml',
                'is_active' => true,
            ],
            [
                'name' => 'Finish Dishwasher Tablets',
                'unit' => 'pack',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 5800.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 6,
                'barcode' => 'FT001',
                'description' => 'Finish dishwasher tablets - 25 tablets',
                'is_active' => true,
            ],
            [
                'name' => 'Garbage Bags (Black)',
                'unit' => 'pack',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 15,
                'barcode' => 'GB001',
                'description' => 'Black garbage bags - 30 bags (medium)',
                'is_active' => true,
            ],
            [
                'name' => 'Floor Polish (Johnson)',
                'unit' => 'bottle',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3800.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 8,
                'barcode' => 'FP001',
                'description' => 'Johnson floor polish - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Glass Cleaner (Invisible Glass)',
                'unit' => 'bottle',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2400.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 12,
                'barcode' => 'GC001',
                'description' => 'Invisible Glass cleaner - 500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Dish Rack (Plastic)',
                'unit' => 'piece',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 3, // Household Items
                'default_minimum_quantity' => 10,
                'barcode' => 'DR001',
                'description' => 'Plastic dish drying rack',
                'is_active' => true,
            ],

            // More Personal Care
            [
                'name' => 'Himalaya Face Wash',
                'unit' => 'tube',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 3000.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 12,
                'barcode' => 'HF001',
                'description' => 'Himalaya neem face wash - 150ml',
                'is_active' => true,
            ],
            [
                'name' => 'Fair & Lovely Cream',
                'unit' => 'tube',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2500.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 15,
                'barcode' => 'FL001',
                'description' => 'Fair & Lovely fairness cream - 25g',
                'is_active' => true,
            ],
            [
                'name' => 'Pond\'s Face Cream',
                'unit' => 'jar',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 3800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 10,
                'barcode' => 'PF001',
                'description' => 'Pond\'s cold cream - 55g',
                'is_active' => true,
            ],
            [
                'name' => 'Old Spice Deodorant',
                'unit' => 'can',
                'default_cost_price' => 2400.00,
                'default_selling_price' => 3200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 12,
                'barcode' => 'OS001',
                'description' => 'Old Spice Swagger deodorant - 150ml',
                'is_active' => true,
            ],
            [
                'name' => 'Rexona Deodorant',
                'unit' => 'can',
                'default_cost_price' => 2600.00,
                'default_selling_price' => 3400.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 12,
                'barcode' => 'RX001',
                'description' => 'Rexona men deodorant - 150ml',
                'is_active' => true,
            ],
            [
                'name' => 'Tresemme Shampoo',
                'unit' => 'bottle',
                'default_cost_price' => 4200.00,
                'default_selling_price' => 5400.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 8,
                'barcode' => 'TS001',
                'description' => 'Tresemme keratin smooth shampoo - 340ml',
                'is_active' => true,
            ],
            [
                'name' => 'Herbal Essences Shampoo',
                'unit' => 'bottle',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 5800.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 8,
                'barcode' => 'HE001',
                'description' => 'Herbal Essences bio renew shampoo - 400ml',
                'is_active' => true,
            ],
            [
                'name' => 'Garnier Face Wash',
                'unit' => 'tube',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3400.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 12,
                'barcode' => 'GF001',
                'description' => 'Garnier pure active face wash - 100ml',
                'is_active' => true,
            ],
            [
                'name' => 'Cetaphil Moisturizer',
                'unit' => 'bottle',
                'default_cost_price' => 5800.00,
                'default_selling_price' => 7500.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 6,
                'barcode' => 'CM001',
                'description' => 'Cetaphil daily facial moisturizer - 118ml',
                'is_active' => true,
            ],
            [
                'name' => 'Veet Hair Removal Cream',
                'unit' => 'tube',
                'default_cost_price' => 3200.00,
                'default_selling_price' => 4200.00,
                'common_category_id' => 4, // Personal Care
                'default_minimum_quantity' => 10,
                'barcode' => 'VH001',
                'description' => 'Veet hair removal cream - 100g',
                'is_active' => true,
            ],

            // More Electronics
            [
                'name' => 'Sandisk Memory Card 64GB',
                'unit' => 'piece',
                'default_cost_price' => 9500.00,
                'default_selling_price' => 12500.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 4,
                'barcode' => 'MC064',
                'description' => 'Sandisk microSD memory card 64GB class 10',
                'is_active' => true,
            ],
            [
                'name' => 'JBL Go 3 Speaker',
                'unit' => 'piece',
                'default_cost_price' => 12000.00,
                'default_selling_price' => 16000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 3,
                'barcode' => 'JB001',
                'description' => 'JBL Go 3 portable Bluetooth speaker',
                'is_active' => true,
            ],
            [
                'name' => 'Anker Power Bank 20000mAh',
                'unit' => 'piece',
                'default_cost_price' => 15000.00,
                'default_selling_price' => 21000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 2,
                'barcode' => 'PB002',
                'description' => 'Anker power bank 20000mAh with quick charge',
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Earbuds',
                'unit' => 'piece',
                'default_cost_price' => 8500.00,
                'default_selling_price' => 12000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 5,
                'barcode' => 'WE001',
                'description' => 'Wireless earbuds with charging case',
                'is_active' => true,
            ],
            [
                'name' => 'Ring Light for Phone',
                'unit' => 'piece',
                'default_cost_price' => 3500.00,
                'default_selling_price' => 5500.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 8,
                'barcode' => 'RL001',
                'description' => 'LED ring light for phone photography',
                'is_active' => true,
            ],
            [
                'name' => 'Car Phone Holder',
                'unit' => 'piece',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 2000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 15,
                'barcode' => 'CP001',
                'description' => 'Car dashboard phone holder mount',
                'is_active' => true,
            ],
            [
                'name' => 'Lightning Cable (iPhone)',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1300.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 20,
                'barcode' => 'LC001',
                'description' => 'Apple lightning charging cable - 1 meter',
                'is_active' => true,
            ],
            [
                'name' => 'Phone Pop Socket',
                'unit' => 'piece',
                'default_cost_price' => 600.00,
                'default_selling_price' => 1000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 25,
                'barcode' => 'PP001',
                'description' => 'Pop socket grip for phone',
                'is_active' => true,
            ],
            [
                'name' => 'Smartphone Ring Light',
                'unit' => 'piece',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 4000.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 10,
                'barcode' => 'SR001',
                'description' => 'Clip-on ring light for smartphone',
                'is_active' => true,
            ],
            [
                'name' => 'USB Extension Cable',
                'unit' => 'piece',
                'default_cost_price' => 400.00,
                'default_selling_price' => 700.00,
                'common_category_id' => 5, // Electronics
                'default_minimum_quantity' => 30,
                'barcode' => 'UE001',
                'description' => 'USB extension cable - 2 meters',
                'is_active' => true,
            ],

            // More Textiles & Clothing
            [
                'name' => 'Cotton Bedsheet',
                'unit' => 'piece',
                'default_cost_price' => 8500.00,
                'default_selling_price' => 12000.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 5,
                'barcode' => 'BS001',
                'description' => 'Cotton bedsheet single size',
                'is_active' => true,
            ],
            [
                'name' => 'Pillowcase (Cotton)',
                'unit' => 'piece',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 15,
                'barcode' => 'PC001',
                'description' => 'Cotton pillowcase - standard size',
                'is_active' => true,
            ],
            [
                'name' => 'Towel (Bath)',
                'unit' => 'piece',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 6500.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 8,
                'barcode' => 'BT001',
                'description' => 'Cotton bath towel',
                'is_active' => true,
            ],
            [
                'name' => 'Curtain Fabric',
                'unit' => 'meter',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 4200.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 12,
                'barcode' => 'CF001',
                'description' => 'Printed curtain fabric per meter',
                'is_active' => true,
            ],
            [
                'name' => 'Zipper (Metal)',
                'unit' => 'piece',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 40,
                'barcode' => 'ZP001',
                'description' => 'Metal zipper 20cm - assorted colors',
                'is_active' => true,
            ],
            [
                'name' => 'Elastic Band',
                'unit' => 'meter',
                'default_cost_price' => 200.00,
                'default_selling_price' => 350.00,
                'common_category_id' => 6, // Textiles & Clothing
                'default_minimum_quantity' => 50,
                'barcode' => 'EB001',
                'description' => 'Elastic band for clothing - 1cm width',
                'is_active' => true,
            ],

            // More Stationery
            [
                'name' => 'A4 Paper (500 sheets)',
                'unit' => 'ream',
                'default_cost_price' => 6500.00,
                'default_selling_price' => 8500.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 8,
                'barcode' => 'A4002',
                'description' => 'A4 white paper - 500 sheets per ream',
                'is_active' => true,
            ],
            [
                'name' => 'Marker Pens (Assorted)',
                'unit' => 'pack',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2600.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 15,
                'barcode' => 'MP001',
                'description' => 'Permanent marker pens - 12 colors',
                'is_active' => true,
            ],
            [
                'name' => 'Stapler (Heavy Duty)',
                'unit' => 'piece',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3800.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 10,
                'barcode' => 'ST001',
                'description' => 'Heavy duty stapler with staples',
                'is_active' => true,
            ],
            [
                'name' => 'Correction Tape',
                'unit' => 'piece',
                'default_cost_price' => 400.00,
                'default_selling_price' => 650.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 25,
                'barcode' => 'CT001',
                'description' => 'Correction tape - 5m',
                'is_active' => true,
            ],
            [
                'name' => 'Highlighter Pens',
                'unit' => 'pack',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 20,
                'barcode' => 'HP001',
                'description' => 'Fluorescent highlighter pens - 6 pack',
                'is_active' => true,
            ],
            [
                'name' => 'Notebook (A5)',
                'unit' => 'piece',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 30,
                'barcode' => 'NB001',
                'description' => 'Ruled notebook A5 - 120 pages',
                'is_active' => true,
            ],
            [
                'name' => 'Envelope (A4)',
                'unit' => 'pack',
                'default_cost_price' => 600.00,
                'default_selling_price' => 900.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 25,
                'barcode' => 'EV001',
                'description' => 'White envelopes A4 - 50 pack',
                'is_active' => true,
            ],
            [
                'name' => 'Paper Clips',
                'unit' => 'box',
                'default_cost_price' => 300.00,
                'default_selling_price' => 500.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 40,
                'barcode' => 'PC001',
                'description' => 'Metal paper clips - 100 pieces',
                'is_active' => true,
            ],
            [
                'name' => 'Push Pins',
                'unit' => 'pack',
                'default_cost_price' => 200.00,
                'default_selling_price' => 350.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 35,
                'barcode' => 'PP001',
                'description' => 'Colored push pins - 50 pieces',
                'is_active' => true,
            ],
            [
                'name' => 'Whiteboard Marker',
                'unit' => 'piece',
                'default_cost_price' => 600.00,
                'default_selling_price' => 900.00,
                'common_category_id' => 7, // Stationery
                'default_minimum_quantity' => 20,
                'barcode' => 'WM001',
                'description' => 'Whiteboard marker pen - black',
                'is_active' => true,
            ],

            // More Hardware & Tools
            [
                'name' => 'Wire Cutters',
                'unit' => 'piece',
                'default_cost_price' => 2800.00,
                'default_selling_price' => 4200.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 6,
                'barcode' => 'WC001',
                'description' => 'Heavy duty wire cutters 8 inch',
                'is_active' => true,
            ],
            [
                'name' => 'Pliers (Combination)',
                'unit' => 'piece',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 3400.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 8,
                'barcode' => 'PL001',
                'description' => 'Combination pliers 7 inch',
                'is_active' => true,
            ],
            [
                'name' => 'Tape Measure',
                'unit' => 'piece',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2300.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 12,
                'barcode' => 'TM001',
                'description' => 'Steel tape measure 5 meters',
                'is_active' => true,
            ],
            [
                'name' => 'Level Tool',
                'unit' => 'piece',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2800.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 10,
                'barcode' => 'LT001',
                'description' => 'Spirit level 24 inch',
                'is_active' => true,
            ],
            [
                'name' => 'Safety Gloves',
                'unit' => 'pair',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1300.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 20,
                'barcode' => 'SG001',
                'description' => 'Work safety gloves - leather',
                'is_active' => true,
            ],
            [
                'name' => 'Extension Cord',
                'unit' => 'piece',
                'default_cost_price' => 3500.00,
                'default_selling_price' => 5200.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 8,
                'barcode' => 'EC001',
                'description' => 'Electrical extension cord 5 meters',
                'is_active' => true,
            ],
            [
                'name' => 'Door Lock (Mortise)',
                'unit' => 'piece',
                'default_cost_price' => 6500.00,
                'default_selling_price' => 9500.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 4,
                'barcode' => 'DL001',
                'description' => 'Mortise door lock with keys',
                'is_active' => true,
            ],
            [
                'name' => 'Door Hinges',
                'unit' => 'pair',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 15,
                'barcode' => 'DH001',
                'description' => 'Brass door hinges 4 inch - pair',
                'is_active' => true,
            ],
            [
                'name' => 'Door Knobs',
                'unit' => 'pair',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2700.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 10,
                'barcode' => 'DK001',
                'description' => 'Brass door knobs - pair',
                'is_active' => true,
            ],
            [
                'name' => 'PVC Pipe 2 inch',
                'unit' => 'meter',
                'default_cost_price' => 800.00,
                'default_selling_price' => 1200.00,
                'common_category_id' => 8, // Hardware & Tools
                'default_minimum_quantity' => 20,
                'barcode' => 'PP001',
                'description' => 'PVC water pipe 2 inch diameter per meter',
                'is_active' => true,
            ],

            // More Agricultural Products
            [
                'name' => 'Cow Feed',
                'unit' => 'kg',
                'default_cost_price' => 1400.00,
                'default_selling_price' => 1800.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 25,
                'barcode' => 'CF002',
                'description' => 'Cattle feed - 50kg bag',
                'is_active' => true,
            ],
            [
                'name' => 'Pig Feed',
                'unit' => 'kg',
                'default_cost_price' => 1600.00,
                'default_selling_price' => 2100.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 20,
                'barcode' => 'PF001',
                'description' => 'Pig grower feed - 50kg bag',
                'is_active' => true,
            ],
            [
                'name' => 'Chicken Layers Mash',
                'unit' => 'kg',
                'default_cost_price' => 1800.00,
                'default_selling_price' => 2300.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 15,
                'barcode' => 'CL001',
                'description' => 'Chicken layers mash feed - 50kg bag',
                'is_active' => true,
            ],
            [
                'name' => 'Dairy Meal',
                'unit' => 'kg',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 2800.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 12,
                'barcode' => 'DM001',
                'description' => 'Dairy meal concentrate - 50kg bag',
                'is_active' => true,
            ],
            [
                'name' => 'Bone Meal Fertilizer',
                'unit' => 'kg',
                'default_cost_price' => 1200.00,
                'default_selling_price' => 1600.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 20,
                'barcode' => 'BM001',
                'description' => 'Bone meal organic fertilizer - 5kg',
                'is_active' => true,
            ],
            [
                'name' => 'Compost Manure',
                'unit' => 'kg',
                'default_cost_price' => 200.00,
                'default_selling_price' => 350.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 50,
                'barcode' => 'CM001',
                'description' => 'Organic compost manure - 50kg bag',
                'is_active' => true,
            ],
            [
                'name' => 'Tomato Seeds',
                'unit' => 'pack',
                'default_cost_price' => 1500.00,
                'default_selling_price' => 2200.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 15,
                'barcode' => 'TS002',
                'description' => 'Tomato seeds - 100g pack',
                'is_active' => true,
            ],
            [
                'name' => 'Onion Seeds',
                'unit' => 'kg',
                'default_cost_price' => 25000.00,
                'default_selling_price' => 32000.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 1,
                'barcode' => 'OS001',
                'description' => 'Onion seeds - 1kg',
                'is_active' => true,
            ],
            [
                'name' => 'Pesticide Spray Pump',
                'unit' => 'piece',
                'default_cost_price' => 4500.00,
                'default_selling_price' => 6500.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 5,
                'barcode' => 'PSP001',
                'description' => 'Manual pesticide spray pump 16 liter',
                'is_active' => true,
            ],
            [
                'name' => 'Garden Hose',
                'unit' => 'meter',
                'default_cost_price' => 600.00,
                'default_selling_price' => 900.00,
                'common_category_id' => 9, // Agricultural Products
                'default_minimum_quantity' => 30,
                'barcode' => 'GH001',
                'description' => 'PVC garden hose per meter',
                'is_active' => true,
            ],

            // More Tobacco & Related
            [
                'name' => 'Rothmans Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2200.00,
                'default_selling_price' => 2700.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 10,
                'barcode' => 'RM001',
                'description' => 'Rothmans cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
            [
                'name' => 'Peter Stuyvesant Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2400.00,
                'default_selling_price' => 2900.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 9,
                'barcode' => 'PS001',
                'description' => 'Peter Stuyvesant cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
            [
                'name' => 'Camel Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2300.00,
                'default_selling_price' => 2800.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 10,
                'barcode' => 'CM001',
                'description' => 'Camel cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
            [
                'name' => 'Winston Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2100.00,
                'default_selling_price' => 2600.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 11,
                'barcode' => 'WN001',
                'description' => 'Winston cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
            [
                'name' => 'Benson & Hedges Cigarettes',
                'unit' => 'pack',
                'default_cost_price' => 2500.00,
                'default_selling_price' => 3100.00,
                'common_category_id' => 10, // Tobacco & Related
                'default_minimum_quantity' => 8,
                'barcode' => 'BH001',
                'description' => 'Benson & Hedges cigarettes - 20 sticks per pack',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            CommonProduct::create($product);
        }
    }
}