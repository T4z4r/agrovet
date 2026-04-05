<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonProduct extends Model
{
    protected $fillable = ['name', 'unit', 'default_cost_price', 'default_selling_price', 'common_category_id', 'default_minimum_quantity', 'barcode', 'photo', 'description', 'is_active'];

    public function commonCategory()

    {

        return $this->belongsTo(CommonCategory::class);

    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
