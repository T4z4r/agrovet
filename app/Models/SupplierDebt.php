<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierDebt extends Model
{
    protected $fillable = ['supplier_id', 'description', 'amount', 'paid', 'date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

