<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AboutSeeder;
use Database\Seeders\BranchSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\CosmeticsProductSeeder;
use Database\Seeders\FeatureSeeder;
use Database\Seeders\KedrikProductSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\PrivacyPolicySeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RolePermissionSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FeatureSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(KedrikProductSeeder::class);
        $this->call(CosmeticsProductSeeder::class);
        $this->call(AboutSeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(PrivacyPolicySeeder::class);

    }
}
