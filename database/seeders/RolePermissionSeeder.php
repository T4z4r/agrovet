<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'delete suppliers',
            'view sales',
            'create sales',
            'edit sales',
            'delete sales',
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            'view reports',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage roles',
            'manage permissions',
            'manage staff',
            'view privacy policies',
            'create privacy policies',
            'edit privacy policies',
            'delete privacy policies',
            'view shops',
            'create shops',
            'edit shops',
            'delete shops',
            'manage subscriptions',
            'view subscription packages',
            'view audits',
            'create subscription packages',
            'edit subscription packages',
            'delete subscription packages',
            'view subscriptions',
            'create subscriptions',
            'edit subscriptions',
            'delete subscriptions',
            'view subscription payments',
            'create subscription payments',
            'edit subscription payments',
            'delete subscription payments',
            'access admin',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $superadminRole->givePermissionTo(Permission::all());

        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $ownerRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'delete suppliers',
            'view sales',
            'create sales',
            'edit sales',
            'delete sales',
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            'view reports',
            'view users',
            'create users',
            'edit users',
            'view subscriptions',
            'create subscriptions',
            'edit subscriptions',
            'view subscription payments',
            'create subscription payments',
            'edit subscription payments',
            'delete users',
            'view privacy policies',
            'view shops',
            'create shops',
            'edit shops',
            'delete shops',
            'view subscription packages',
            'create subscription packages',
            'edit subscription packages',
            'delete subscription packages',
            'view subscriptions',
            'create subscriptions',
            'edit subscriptions',
            'delete subscriptions',
            'view subscription payments',
            'create subscription payments',
            'edit subscription payments',
            'delete subscription payments',
            // Owner cannot manage roles and permissions or access admin
        ]);

        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $sellerRole->givePermissionTo([
            'view products',
            'view suppliers',
            'view sales',
            'create sales',
            'view expenses',
            'create expenses',
            'view reports',
        ]);

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view suppliers',
            'create suppliers',
            'edit suppliers',
            'view sales',
            'create sales',
            'edit sales',
            'view expenses',
            'create expenses',
            'edit expenses',
            'view reports',
            'view users',
            'create users',
            'edit users',
        ]);
    }
}
