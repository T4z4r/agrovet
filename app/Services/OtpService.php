<?php

namespace App\Services;

use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    /**
     * Generate and send OTP for a user
     */
    public function sendOtp(User $user, string $purpose = 'login', int $length = 6, int $expiresInMinutes = 30): void
    {
        $otp = $this->generateOtpCode($length);
        $expiresAt = now()->addMinutes($expiresInMinutes);

        // Store OTP in database
        $user->otp_code = $otp;
        $user->otp_expires_at = $expiresAt;
        $user->save();

        // Send mail
        Mail::to($user->email)->send(new OtpMail($otp, $purpose));
    }

    /**
     * Verify OTP for a user
     */
    public function verifyOtp(User $user, string $code, string $purpose = 'login'): bool
    {
        if (!$user->otp_code || !$user->otp_expires_at) {
            return false; // OTP not set
        }

        if (now()->greaterThan($user->otp_expires_at)) {
            // Expired, clear it
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();
            return false;
        }

        if ($user->otp_code === $code) {
            // Clear OTP after successful verification
            $user->otp_code = null;
            $user->otp_expires_at = null;
            $user->save();
            return true;
        }

        return false;
    }

    /**
     * Check if OTP exists and is valid for a user
     */
    public function hasValidOtp(User $user, string $purpose = 'login'): bool
    {
        return $user->otp_code && $user->otp_expires_at && now()->lessThan($user->otp_expires_at);
    }

    /**
     * Clear OTP for a user
     */
    public function clearOtp(User $user, string $purpose = 'login'): void
    {
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();
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
        if (!$user->otp_expires_at) {
            return null;
        }

        return now()->diffInMinutes($user->otp_expires_at, false);
    }
}