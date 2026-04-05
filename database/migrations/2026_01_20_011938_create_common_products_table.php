<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('common_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit', 50);
            $table->decimal('default_cost_price', 12, 2)->nullable();
            $table->decimal('default_selling_price', 12, 2)->nullable();
            $table->foreignId('common_category_id')->constrained('common_categories')->onDelete('cascade');
            $table->double('default_minimum_quantity')->default(0.00);
            $table->string('barcode')->nullable();
            $table->string('photo')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('common_products');
    }
};
