<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP for a specific purpose
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'purpose' => 'required|string|in:login,email_verification,password_reset,security'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Check if user already has a valid OTP for this purpose
        if ($this->otpService->hasValidOtp($user, $data['purpose'])) {
            return response()->json([
                'success' => false,
                'message' => 'OTP already sent. Please check your email.'
            ], 429);
        }

        $this->otpService->sendOtp($user, $data['purpose']);

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully to your email.'
        ]);
    }

    /**
     * Verify OTP for a specific purpose
     */
    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6',
            'purpose' => 'required|string|in:login,email_verification,password_reset,security'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        if ($this->otpService->verifyOtp($user, $data['otp_code'], $data['purpose'])) {
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully.',
                'data' => [
                    'user' => $user,
                    'purpose' => $data['purpose']
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired OTP'
        ], 401);
    }

    /**
     * Check OTP status
     */
    public function status(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'purpose' => 'required|string|in:login,email_verification,password_reset,security'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $hasValidOtp = $this->otpService->hasValidOtp($user, $data['purpose']);
        $remainingTime = $this->otpService->getRemainingTime($user, $data['purpose']);

        return response()->json([
            'success' => true,
            'data' => [
                'has_valid_otp' => $hasValidOtp,
                'remaining_minutes' => $remainingTime
            ]
        ]);
    }

    /**
     * Clear OTP (for admin or cleanup purposes)
     */
    public function clear(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'purpose' => 'required|string|in:login,email_verification,password_reset,security'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $this->otpService->clearOtp($user, $data['purpose']);

        return response()->json([
            'success' => true,
            'message' => 'OTP cleared successfully.'
        ]);
    }
}