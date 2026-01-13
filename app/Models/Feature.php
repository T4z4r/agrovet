<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Feature extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

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
