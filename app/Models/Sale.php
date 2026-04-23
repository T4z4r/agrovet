<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Sale extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    protected $casts = [
        'sale_date' => 'date',
        'total' => 'decimal:2',
    ];

    protected $fillable = [
        'branch_id',
        'seller_id',
        'sale_date',
        'total',
        'payment_method',
        'customer_name',
        'shop_id'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
