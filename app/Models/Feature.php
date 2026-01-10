<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function subscriptionPackages()
    {
        return $this->belongsToMany(SubscriptionPackage::class, 'feature_subscription_package');
    }
}
