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
        ];

        foreach ($categories as $category) {
            CommonCategory::create($category);
        }
    }
}