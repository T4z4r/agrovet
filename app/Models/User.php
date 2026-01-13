<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Auditable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, Auditable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'branch_id',
        'shop_id',
        'otp_verified',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',           // ← usually don't expose OTP
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'otp_expires_at'    => 'datetime',
            'otp_verified'      => 'boolean',
            'is_active'         => 'boolean',
        ];
    }

    // ────────────────────────────────────────────────
    // Relationships
    // ────────────────────────────────────────────────

    /**
     * Shops owned by this user (if user is owner)
     */
    public function shops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    /**
     * The shop this user belongs to / works at
     * (rename if it better reflects "assigned shop" vs "owned shop")
     */
    public function assignedShop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'seller_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // ────────────────────────────────────────────────
    // OTP Helpers
    // ────────────────────────────────────────────────

    public function generateOtp(): void
    {
        $this->otp_code      = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_expires_at = Carbon::now()->addMinutes(30);
        $this->otp_verified   = false; // reset verification status

        $this->saveQuietly(); // avoid events if not needed

        $this->notify(new \App\Notifications\OtpNotification($this->otp_code));
    }

    public function verifyOtp(string $code): bool
    {
        if ($this->otp_code === $code && $this->otp_expires_at?->isFuture()) {
            $this->otp_code       = null;
            $this->otp_expires_at = null;
            $this->otp_verified   = true;
            $this->saveQuietly();

            return true;
        }

        return false;
    }

    public function isOtpExpired(): bool
    {
        return $this->otp_expires_at !== null && $this->otp_expires_at->isPast();
    }

    // ────────────────────────────────────────────────
    // Model Events
    // ────────────────────────────────────────────────

    // protected static function booted(): void
    // {
    //     static::created(function (User $user) {
    //         // Give free subscription on creation
    //         $freePackage = SubscriptionPackage::firstOrCreate(['name' => 'Free'], [
    //             'description' => 'Free subscription package',
    //             'price' => 0,
    //             'duration_months' => 12,
    //             'is_active' => true,
    //         ]);

    //         Subscription::create([
    //             'user_id'                 => $user->id,
    //             'subscription_package_id' => $freePackage->id,
    //             'start_date'              => now(),
    //             'end_date'                => now()->addYear(), // ← changed to addYear() for clarity
    //             'status'                  => 'active',
    //         ]);
    //     });
    // }
}
