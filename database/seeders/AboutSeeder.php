<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'title' => 'About AgroVet',
            'content' => 'AgroVet is a comprehensive livestock and agricultural management system designed to streamline operations for farmers and veterinarians. Our platform helps manage products, sales, expenses, and stock levels efficiently.'
        ]);
    }
}
