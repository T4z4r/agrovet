<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class GeneralDebtPayment extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    protected $fillable = [
        'general_debt_id',
        'recorded_by',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function debt()
    {
        return $this->belongsTo(GeneralDebt::class, 'general_debt_id');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
