<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;

class Product extends Model
{
    use HasFactory, Auditable;
    protected $fillable = ['shop_id', 'branch_id', 'name', 'unit', 'category', 'stock', 'cost_price', 'selling_price', 'minimum_quantity', 'barcode', 'photo'];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
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
