<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'seller' // default role
        ]);

        Auth::login($user);

        return redirect(route('dashboard'));
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
        if (auth()->user()->role === 'seller') {
            return redirect()->route('web.pos.index');
        }

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
