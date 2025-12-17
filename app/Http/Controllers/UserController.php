<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Only owners can view sellers
        if (auth()->user()->role !== 'owner') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $sellers = User::where('role', 'seller')->get();

        return response()->json([
            'success' => true,
            'data' => $sellers,
            'message' => 'Sellers retrieved successfully'
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'seller'; // Force role to seller

        $user = User::create($data);

        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => 'Seller created successfully'
        ]);
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'owner') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $seller = User::where('role', 'seller')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $seller,
            'message' => 'Seller retrieved successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'owner') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $seller = User::where('role', 'seller')->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $seller->update($data);

        return response()->json([
            'success' => true,
            'data' => $seller,
            'message' => 'Seller updated successfully'
        ]);
    }

    public function block($id)
    {
        if (auth()->user()->role !== 'owner') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $seller = User::where('role', 'seller')->findOrFail($id);
        $seller->update(['is_active' => !$seller->is_active]);

        $status = $seller->is_active ? 'unblocked' : 'blocked';

        return response()->json([
            'success' => true,
            'data' => $seller,
            'message' => "Seller {$status} successfully"
        ]);
    }

    public function sellerReport(Request $request, $id)
    {
        if (auth()->user()->role !== 'owner') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $seller = User::where('role', 'seller')->findOrFail($id);

        $start = $request->query('start');
        $end = $request->query('end');

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

        return response()->json([
            'success' => true,
            'data' => [
                'seller' => $seller,
                'sales' => $sales,
                'total_sales' => $totalSales,
                'expenses' => $expenses,
                'total_expenses' => $totalExpenses,
                'stock_transactions' => $stockTransactions,
            ],
            'message' => 'Seller report retrieved successfully'
        ]);
    }
}
