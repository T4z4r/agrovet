<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
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
        'otp_expires_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
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

    public function generateOtp()
    {
        $this->otp_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_expires_at = now()->addMinutes(30); // OTP expires in 30 minutes
        $this->save();

        $this->notify(new \App\Notifications\OtpNotification($this->otp_code));
    }

    public function verifyOtp($code)
    {
        if ($this->otp_code === $code && $this->otp_expires_at > now()) {
            $this->otp_code = null;
            $this->otp_expires_at = null;
            $this->save();
            return true;
        }
        return false;
    }

    public function isOtpExpired()
    {
        return $this->otp_expires_at && $this->otp_expires_at <= now();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            $freePackage = SubscriptionPackage::where('name', 'Free')->first();
            if ($freePackage) {
                Subscription::create([
                    'user_id' => $user->id,
                    'subscription_package_id' => $freePackage->id,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(12), // Extend for testing
                    'status' => 'active',
                ]);
            }
        });
    }
}
