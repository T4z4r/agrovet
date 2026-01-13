<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Shop extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    protected $fillable = ['name', 'owner_id', 'location'];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
