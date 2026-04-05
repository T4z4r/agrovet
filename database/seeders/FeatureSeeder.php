<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name' => 'Inventory Management',
                'description' => 'Manage products, stock levels, and inventory tracking',
                'is_active' => true,
            ],
            [
                'name' => 'Sales Tracking',
                'description' => 'Track sales, generate receipts, and manage transactions',
                'is_active' => true,
            ],
            [
                'name' => 'Supplier Management',
                'description' => 'Manage suppliers, orders, and supplier debts',
                'is_active' => true,
            ],
            [
                'name' => 'Customer Management',
                'description' => 'Manage customer information and purchase history',
                'is_active' => true,
            ],
            [
                'name' => 'Reporting',
                'description' => 'Generate sales reports, inventory reports, and analytics',
                'is_active' => true,
            ],
            [
                'name' => 'Multi-shop Support',
                'description' => 'Manage multiple shop locations',
                'is_active' => true,
            ],
            [
                'name' => 'User Management',
                'description' => 'Manage users, roles, and permissions',
                'is_active' => true,
            ],
            [
                'name' => 'Barcode Scanning',
                'description' => 'Scan barcodes for quick product lookup and sales',
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
