<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'shop_id',
        'subscription_package_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function subscriptionPackage()
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }

    public function payments()
    {
        return $this->hasMany(SubscriptionPayment::class);
    }
}
