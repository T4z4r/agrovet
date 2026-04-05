<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class SupplierDebt extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    protected $fillable = ['supplier_id', 'description', 'amount', 'paid', 'date'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

