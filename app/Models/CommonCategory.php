<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonCategory extends Model
{
    protected $fillable = ['name', 'description', 'is_active'];

    public function commonProducts()

    {

        return $this->hasMany(CommonProduct::class);

    }
}
