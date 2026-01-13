<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class SubscriptionPackage extends Model
{
    use Auditable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_months',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_subscription_package', 'subscription_package_id', 'feature_id');
    }
}
