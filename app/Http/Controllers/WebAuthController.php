<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Expense;

class WebAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

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
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6|confirmed',
            'shop_name'         => 'required|string',
            'shop_location'     => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => 'owner',
        ]);

        $user->assignRole('owner');

        $shop = Shop::create([
            'name'     => $data['shop_name'],
            'owner_id' => $user->id,
            'location' => $data['shop_location'] ?? null,
        ]);

        $user->shop_id = $shop->id;
        $user->save();

        Auth::login($user);

        return redirect()->route('dashboard');
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

        // Admin/Owner dashboard
        $data = [
            'total_products'  => Product::count(),
            'total_sales'     => Sale::sum('total'),
            'total_expenses'  => Expense::sum('amount'),
            'today_sales'     => Sale::whereDate('sale_date', today())->sum('total'),
            'stock_value'     => Product::sum(DB::raw('cost_price * stock')),
        ];

        // Data for charts - last 30 days
        $dates = [];
        $salesData = [];
        $expensesData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates[] = now()->subDays($i)->format('M d');
            $salesData[] = Sale::whereDate('sale_date', $date)->sum('total');
            $expensesData[] = Expense::whereDate('date', $date)->sum('amount');
        }

        return view('dashboard', compact('data', 'dates', 'salesData', 'expensesData'));
    }
}
