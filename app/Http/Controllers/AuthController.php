<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|confirmed',
            'role' => 'required|in:admin,owner,seller',
            'shop_name' => 'required_if:role,owner|string',
            'shop_location' => 'required_if:role,owner|string',
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        if ($data['role'] === 'owner') {
            Shop::create([
                'name' => $data['shop_name'],
                'owner_id' => $user->id,
                'location' => $data['shop_location'],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('agrovet')->plainTextToken
            ],
            'message' => 'User registered successfully'
        ]);
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
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'token' => $user->createToken('agrovet')->plainTextToken
            ],
            'message' => 'User logged in successfully'
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
