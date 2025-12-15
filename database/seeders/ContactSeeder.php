<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create(['type' => 'phone', 'value' => '+254 700 123 456']);
        Contact::create(['type' => 'email', 'value' => 'info@agrovet.com']);
        Contact::create(['type' => 'address', 'value' => '123 Farm Road, Nairobi, Kenya']);
    }
}
