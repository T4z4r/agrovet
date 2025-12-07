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
        Schema::create('daily_sales_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops');
            $table->date('date');
            $table->decimal('total_sales', 12, 2);
            $table->integer('total_stock_in');
            $table->integer('total_stock_out');
            $table->integer('total_damage');
            $table->integer('total_returns');
            $table->decimal('total_expenses', 12, 2);
            $table->decimal('net_profit', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_sales_reports');
    }
};
