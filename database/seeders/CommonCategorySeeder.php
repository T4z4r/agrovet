<?php

namespace Database\Seeders;

use App\Models\CommonCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommonCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Food & Groceries',
                'description' => 'Staple foods, grains, and grocery items',
                'is_active' => true,
            ],
            [
                'name' => 'Beverages',
                'description' => 'Soft drinks, water, and beverages',
                'is_active' => true,
            ],
            [
                'name' => 'Household Items',
                'description' => 'Cleaning supplies and household essentials',
                'is_active' => true,
            ],
            [
                'name' => 'Personal Care',
                'description' => 'Soap, toothpaste, and personal hygiene products',
                'is_active' => true,
            ],
            [
                'name' => 'Electronics',
                'description' => 'Mobile phones, chargers, and electronic accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Textiles & Clothing',
                'description' => 'Kangas, vitenges, and clothing items',
                'is_active' => true,
            ],
            [
                'name' => 'Stationery',
                'description' => 'Pens, notebooks, and school supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Hardware & Tools',
                'description' => 'Nails, wires, and basic hardware items',
                'is_active' => true,
            ],
            [
                'name' => 'Agricultural Products',
                'description' => 'Seeds, fertilizers, and farming supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Tobacco & Related',
                'description' => 'Cigarettes and tobacco products',
                'is_active' => true,
            ],
            [
                'name' => 'Spices & Seasonings',
                'description' => 'Spices, herbs, and cooking seasonings',
                'is_active' => true,
            ],
            [
                'name' => 'Fresh Produce',
                'description' => 'Fruits and vegetables',
                'is_active' => true,
            ],
            [
                'name' => 'Dairy Products',
                'description' => 'Milk, cheese, and dairy items',
                'is_active' => true,
            ],
            [
                'name' => 'Bakery Products',
                'description' => 'Bread, cakes, and baked goods',
                'is_active' => true,
            ],
            [
                'name' => 'Canned & Packaged Foods',
                'description' => 'Canned goods and packaged food items',
                'is_active' => true,
            ],
            [
                'name' => 'Alcoholic Beverages',
                'description' => 'Beer, wine, and spirits',
                'is_active' => true,
            ],
            [
                'name' => 'Cosmetics & Beauty',
                'description' => 'Makeup, skincare, and beauty products',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home decor and garden supplies',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car parts and automotive accessories',
                'is_active' => true,
            ],
            [
                'name' => 'Pet Supplies',
                'description' => 'Pet food and pet care products',
                'is_active' => true,
            ],
            [
                'name' => 'Baby Products',
                'description' => 'Baby food, diapers, and baby care items',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Recreation',
                'description' => 'Sports equipment and recreational items',
                'is_active' => true,
            ],
            [
                'name' => 'Books & Media',
                'description' => 'Books, magazines, and media products',
                'is_active' => true,
            ],
            [
                'name' => 'Health & Pharmacy',
                'description' => 'Medicines, vitamins, and health products',
                'is_active' => true,
            ],
            [
                'name' => 'Electrical Appliances',
                'description' => 'Fans, irons, and small electrical appliances',
                'is_active' => true,
            ],
            [
                'name' => 'Furniture & Furnishings',
                'description' => 'Furniture and home furnishing items',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            CommonCategory::create($category);
        }
    }
}