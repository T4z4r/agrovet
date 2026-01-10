<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_date',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function shop()
    {
        return $this->hasOneThrough(Shop::class, Subscription::class, 'id', 'id', 'subscription_id', 'shop_id');
    }
}
