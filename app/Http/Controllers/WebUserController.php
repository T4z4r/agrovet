<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WebUserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $users = User::where('role', 'seller')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'seller';

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $user = User::where('role', 'seller')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $user = User::where('role', 'seller')->findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $user = User::where('role', 'seller')->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        User::where('role', 'seller')->findOrFail($id)->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function block($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $user = User::where('role', 'seller')->findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'unblocked' : 'blocked';

        return redirect()->route('users.index')->with('success', "User {$status} successfully");
    }

    public function sellerReport($id)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized');
        }

        $user = User::where('role', 'seller')->findOrFail($id);

        $start = request('start');
        $end = request('end');

        $sales = Sale::with('items.product')
            ->where('seller_id', $id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('sale_date', [$start, $end]);
            })
            ->get();

        $totalSales = $sales->sum('total');

        $expenses = Expense::where('recorded_by', $id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('date', [$start, $end]);
            })
            ->get();

        $totalExpenses = $expenses->sum('amount');

        $stockTransactions = StockTransaction::with('product', 'supplier')
            ->where('recorded_by', $id)
            ->when($start && $end, function ($q) use ($start, $end) {
                $q->whereBetween('date', [$start, $end]);
            })
            ->get();

        return view('users.report', compact('user', 'sales', 'totalSales', 'expenses', 'totalExpenses', 'stockTransactions'));
    }
}