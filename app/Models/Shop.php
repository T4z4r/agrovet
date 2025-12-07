<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'owner_id', 'location'];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
