<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;

class Product extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;
    protected $fillable = ['shop_id', 'branch_id', 'name', 'unit', 'category', 'stock', 'cost_price', 'selling_price', 'minimum_quantity', 'barcode', 'photo'];
    protected $casts = [
        'stock' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'minimum_quantity' => 'decimal:2',
    ];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function commonProduct()

    {

        return $this->belongsTo(CommonProduct::class);

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
