<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'seller_id',
        'sale_date',
        'total',
        'payment_method',
        'customer_name'
    ];

    protected $casts = [
        'sale_date' => 'date',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
