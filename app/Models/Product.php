<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'name', 'unit', 'category', 'stock', 'cost_price', 'selling_price', 'minimum_quantity'];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}
