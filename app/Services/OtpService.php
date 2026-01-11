<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Cache;

class OtpService
{
    /**
     * Generate and send OTP for a user
     */
    public function sendOtp(User $user, string $purpose = 'login', int $length = 6, int $expiresInMinutes = 10): void
    {
        $otp = $this->generateOtpCode($length);
        $expiresAt = now()->addMinutes($expiresInMinutes);

        // Store OTP in cache with user ID and purpose
        $cacheKey = "otp_{$user->id}_{$purpose}";
        Cache::put($cacheKey, [
            'code' => $otp,
            'expires_at' => $expiresAt,
            'attempts' => 0
        ], $expiresInMinutes);

        // Send notification
        $user->notify(new OtpNotification($otp, $purpose));
    }

    /**
     * Verify OTP for a user
     */
    public function verifyOtp(User $user, string $code, string $purpose = 'login'): bool
    {
        $cacheKey = "otp_{$user->id}_{$purpose}";
        $otpData = Cache::get($cacheKey);

        if (!$otpData) {
            return false; // OTP not found or expired
        }

        // Check attempts (max 3 attempts)
        if ($otpData['attempts'] >= 3) {
            Cache::forget($cacheKey); // Lock out after max attempts
            return false;
        }

        if ($otpData['code'] === $code && now()->lessThan($otpData['expires_at'])) {
            Cache::forget($cacheKey); // Clear OTP after successful verification
            return true;
        }

        // Increment attempts on failure
        $otpData['attempts']++;
        Cache::put($cacheKey, $otpData, now()->diffInMinutes($otpData['expires_at']));

        return false;
    }

    /**
     * Check if OTP exists and is valid for a user
     */
    public function hasValidOtp(User $user, string $purpose = 'login'): bool
    {
        $cacheKey = "otp_{$user->id}_{$purpose}";
        $otpData = Cache::get($cacheKey);

        return $otpData && now()->lessThan($otpData['expires_at']) && $otpData['attempts'] < 3;
    }

    /**
     * Clear OTP for a user
     */
    public function clearOtp(User $user, string $purpose = 'login'): void
    {
        $cacheKey = "otp_{$user->id}_{$purpose}";
        Cache::forget($cacheKey);
    }

    /**
     * Generate a random OTP code
     */
    private function generateOtpCode(int $length = 6): string
    {
        return str_pad((string) random_int(0, 10 ** $length - 1), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Get remaining time for OTP in minutes
     */
    public function getRemainingTime(User $user, string $purpose = 'login'): ?int
    {
        $cacheKey = "otp_{$user->id}_{$purpose}";
        $otpData = Cache::get($cacheKey);

        if (!$otpData) {
            return null;
        }

        return now()->diffInMinutes($otpData['expires_at'], false);
    }
}