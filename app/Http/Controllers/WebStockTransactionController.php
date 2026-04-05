<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebStockTransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = StockTransaction::with('product', 'supplier', 'user');
        if (!$user->hasRole('superadmin')) {
            $query->where('shop_id', $user->shop_id);
        }

        if ($request->ajax()) {
            $transactions = $query->latest()->get();
            return response()->json([
                'data' => $transactions
            ]);
        }

        $transactions = $query->latest()->get();
        return view('stock-transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('superadmin')) {
            $products = Product::orderBy('name')->get();
            $suppliers = Supplier::orderBy('name')->get();
        } else {
            $products = Product::where('shop_id', $user->shop_id)->orderBy('name')->get();
            $suppliers = Supplier::where('shop_id', $user->shop_id)->orderBy('name')->get();
        }
        return view('stock-transactions.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:stock_in,stock_out,damage,return',
            'quantity' => 'required|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date' => 'required|date',
            'remarks' => 'nullable|string'
        ]);

        $data['recorded_by'] = auth()->id();

        // Update product stock
        $product = Product::find($data['product_id']);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $product->shop_id != $user->shop_id) {
            return back()->withErrors(['product_id' => 'Product not in your shop']);
        }
        $data['shop_id'] = $product->shop_id;
        if ($data['type'] === 'stock_in' || $data['type'] === 'return') {
            $product->stock += $data['quantity'];
        } else {
            if ($product->stock < $data['quantity']) {
                return back()->withErrors(['quantity' => 'Insufficient stock']);
            }
            $product->stock -= $data['quantity'];
        }
        $product->save();

        StockTransaction::create($data);

        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction created successfully');
    }

    public function show($id)
    {
        $transaction = StockTransaction::with('product', 'supplier', 'user')->findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $transaction->shop_id != $user->shop_id) {
            abort(403);
        }
        return view('stock-transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $transaction->shop_id != $user->shop_id) {
            abort(403);
        }
        if ($user->hasRole('superadmin')) {
            $products = Product::orderBy('name')->get();
            $suppliers = Supplier::orderBy('name')->get();
        } else {
            $products = Product::where('shop_id', $user->shop_id)->orderBy('name')->get();
            $suppliers = Supplier::where('shop_id', $user->shop_id)->orderBy('name')->get();
        }
        return view('stock-transactions.edit', compact('transaction', 'products', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $transaction->shop_id != $user->shop_id) {
            abort(403);
        }
        $data = $request->validate([
            'type' => 'nullable|in:stock_in,stock_out,damage,return',
            'quantity' => 'nullable|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date' => 'nullable|date',
            'remarks' => 'nullable|string',
            'shop_id' => 'nullable|exists:shops,id'
        ]);
        $transaction->update($data);
        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction updated successfully');
    }

    public function destroy($id)
    {
        $tx = StockTransaction::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $tx->shop_id != $user->shop_id) {
            abort(403);
        }
        $product = $tx->product;

        if ($tx->type === 'stock_in' || $tx->type === 'return') {
            if ($product->stock < $tx->quantity) {
                return back()->withErrors(['message' => 'Cannot delete transaction: insufficient stock']);
            }
            $product->stock -= $tx->quantity;
        } else {
            $product->stock += $tx->quantity;
        }

        $product->save();
        $tx->delete();

        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction deleted successfully');
    }
}
