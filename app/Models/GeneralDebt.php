<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

class GeneralDebt extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use Auditable;

    protected $fillable = [
        'shop_id',
        'recorded_by',
        'debtor_name',
        'debtor_phone',
        'debtor_email',
        'description',
        'amount',
        'amount_paid',
        'debt_date',
        'due_date',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'debt_date' => 'date',
        'due_date' => 'date',
    ];

    protected $appends = ['balance'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function payments()
    {
        return $this->hasMany(GeneralDebtPayment::class);
    }

    public function getBalanceAttribute(): float
    {
        return max(round((float) $this->amount - (float) $this->amount_paid, 2), 0);
    }

    public function refreshPaymentState(): void
    {
        $paid = (float) $this->payments()->sum('amount');

        $this->amount_paid = min($paid, (float) $this->amount);
        $this->status = match (true) {
            $this->amount_paid <= 0 => 'unpaid',
            $this->amount_paid >= (float) $this->amount => 'paid',
            default => 'partial',
        };
        $this->save();
    }
}
