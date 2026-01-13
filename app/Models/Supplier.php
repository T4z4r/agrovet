<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class Supplier extends Model
{
    use Auditable;

    protected $fillable = ['name', 'contact_person', 'phone', 'email', 'address'];
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}
