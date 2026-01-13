<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class StockTransaction extends Model
{
    use Auditable;

    protected $fillable = [
        'branch_id',
        'product_id',
        'type',
        'quantity',
        'supplier_id',
        'recorded_by',
        'date',
        'remarks',
        'shop_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
