<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use App\Services\OtpService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|confirmed',
            'role' => 'required|string',
            'shop_name' => 'nullable|string',
            'shop_location' => 'nullable|string',
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);


        $user=User::where('email',$data['email'])->first();

          if ($data['role'] === 'owner') {
            $shop = Shop::create([
                'name' => $data['shop_name'],
                'owner_id' => $user->id,
                'location' => $data['shop_location'],
            ]);
            $user->shop_id = $shop->id;
            $user->save();
        }

        // Generate and send OTP
        $this->otpService->sendOtp($user, 'register');

      

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully. OTP sent to your email. Please verify to complete registration.'
        ], 201);
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
