<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:users,email',
            'password'       => 'required|confirmed|min:8',
            'shop_name'      => 'nullable|string|max:255',
            'shop_location'  => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // Create user (ONLY user fields)
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Create shop if provided
            if (!empty($validated['shop_name'])) {
                $shop = Shop::create([
                    'name'      => $validated['shop_name'],
                    'owner_id'  => $user->id,
                    'location'  => $validated['shop_location'] ?? null,
                ]);

                $user->update([
                    'shop_id' => $shop->id,
                ]);
            }

            // Send OTP
            $this->otpService->sendOtp($user, 'register');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully. OTP sent to your email. Please verify to complete registration.',
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }
    }

    public function login(Request $r)
    {
        $creds = $r->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($creds)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        if (!$user->otp_verified) {
            // Send OTP for verification
            $this->otpService->sendOtp($user, 'login');
            return response()->json([
                'success' => false,
                'message' => 'Account not verified. OTP sent to your email. Please verify to login.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('agrovet')->plainTextToken
            ],
            'message' => 'Logged in successfully'
        ]);
    }

    public function verifyOtp(Request $r)
    {
        $data = $r->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        if ($this->otpService->verifyOtp($user, $data['otp_code'], 'register')) {
            $user->otp_verified = true;
            $user->save();
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'token' => $user->createToken('agrovet')->plainTextToken
                ],
                'message' => 'OTP verified successfully. Logged in.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired OTP'
        ], 401);
    }

    public function resendOtp(Request $r)
    {
        $data = $r->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Check if there's an existing OTP and if it's not expired
        if ($this->otpService->hasValidOtp($user, 'register')) {
            return response()->json([
                'success' => false,
                'message' => 'OTP already sent. Please wait before requesting a new one.'
            ], 429);
        }

        $this->otpService->sendOtp($user, 'register');

        return response()->json([
            'success' => true,
            'message' => 'New OTP sent to your email.'
        ]);
    }

    public function me(Request $r)
    {
        return response()->json([
            'success' => true,
            'data' => $r->user(),
            'message' => 'User data retrieved successfully'
        ]);
    }

    public function logout(Request $r)
    {
        /** @var PersonalAccessToken|null $token */
        $token = $r->user()->currentAccessToken();
        if ($token) {
            $token->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
}
