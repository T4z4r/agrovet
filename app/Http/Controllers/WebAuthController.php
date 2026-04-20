<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Shop;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebAuthController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $this->otpService->hasValidOtp($user, 'login')) {
            $request->session()->put('pending_user_id', $user->id);

            return redirect()->route('otp.verify');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'shop_name' => 'required|string',
            'shop_location' => 'nullable|string',
        ]);

        $tempData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'shop_name' => $data['shop_name'],
            'shop_location' => $data['shop_location'] ?? null,
        ];

        $request->session()->put('registration_data', $tempData);
        $request->session()->put('registration_step', 'otp');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'owner',
        ]);

        $this->otpService->sendOtp($user, 'register');

        return redirect()->route('otp.verify')->with('success', 'OTP sent to your email. Please verify to complete registration.');
    }

    public function showOtpVerify()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|digits:6',
        ]);

        $userId = $request->session()->get('pending_user_id');
        $registrationData = $request->session()->get('registration_data');

        if ($registrationData) {
            $user = User::where('email', $registrationData['email'])->first();
            if (! $user) {
                $request->session()->forget(['registration_data', 'registration_step']);

                return redirect()->route('register')->with('error', 'Registration session expired.');
            }

            if (! $this->otpService->verifyOtp($user, $request->otp_code, 'register')) {
                return back()->with('error', 'Invalid or expired OTP.');
            }

            $user->assignRole('owner');

            $shop = Shop::create([
                'name' => $registrationData['shop_name'],
                'owner_id' => $user->id,
                'location' => $registrationData['shop_location'] ?? null,
            ]);

            $user->shop_id = $shop->id;
            $user->save();

            $request->session()->forget(['registration_data', 'registration_step']);
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Registration completed successfully!');
        }

        if ($userId) {
            $user = User::find($userId);
            if (! $user) {
                return redirect()->route('login')->with('error', 'Session expired.');
            }

            if (! $this->otpService->verifyOtp($user, $request->otp_code, 'login')) {
                return back()->with('error', 'Invalid or expired OTP.');
            }

            $request->session()->forget('pending_user_id');
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return redirect()->route('login')->with('error', 'Invalid session.');
    }

    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get('pending_user_id');
        $registrationData = $request->session()->get('registration_data');

        if ($registrationData) {
            $user = User::where('email', $registrationData['email'])->first();
            if ($user) {
                $this->otpService->sendOtp($user, 'register');

                return back()->with('success', 'OTP resent to your email.');
            }
        }

        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $this->otpService->sendOtp($user, 'login');

                return back()->with('success', 'OTP resent to your email.');
            }
        }

        return back()->with('error', 'Unable to resend OTP.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        $user = auth()->user();

        if ($user->hasRole('seller')) {
            // Seller-specific dashboard
            $sellerId = $user->id;
            $today = today();

            $data = [
                'today_sales' => Sale::where('seller_id', $sellerId)->whereDate('sale_date', $today)->sum('total'),
                'today_expenses' => Expense::where('recorded_by', $sellerId)->whereDate('date', $today)->sum('amount'),
                'month_sales' => Sale::where('seller_id', $sellerId)->whereMonth('sale_date', $today->month)->whereYear('sale_date', $today->year)->sum('total'),
                'month_expenses' => Expense::where('recorded_by', $sellerId)->whereMonth('date', $today->month)->whereYear('date', $today->year)->sum('amount'),
                'total_sales_count' => Sale::where('seller_id', $sellerId)->count(),
                'today_sales_count' => Sale::where('seller_id', $sellerId)->whereDate('sale_date', $today)->count(),
            ];

            // Recent sales for the seller
            $recentSales = Sale::with('items.product')
                ->where('seller_id', $sellerId)
                ->whereDate('sale_date', $today)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard-seller', compact('data', 'recentSales'));
        }

        // Admin/Owner dashboard — scope everything to this owner's shop
        $shopId = $user->shop_id;

        $data = [
            'total_products' => Product::where('shop_id', $shopId)->count(),
            'total_sales' => Sale::where('shop_id', $shopId)->sum('total'),
            'total_expenses' => Expense::where('shop_id', $shopId)->sum('amount'),
            'today_sales' => Sale::where('shop_id', $shopId)->whereDate('sale_date', today())->sum('total'),
            'stock_value' => Product::where('shop_id', $shopId)->sum(DB::raw('cost_price * stock')),
        ];

        // Data for charts - last 30 days (scoped to this shop)
        $dates = [];
        $salesData = [];
        $expensesData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates[] = now()->subDays($i)->format('M d');
            $salesData[] = (float) Sale::where('shop_id', $shopId)->whereDate('sale_date', $date)->sum('total');
            $expensesData[] = (float) Expense::where('shop_id', $shopId)->whereDate('date', $date)->sum('amount');
        }

        return view('dashboard', compact('data', 'dates', 'salesData', 'expensesData'));
    }
}
