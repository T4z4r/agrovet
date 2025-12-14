<?php

namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class WebStockTransactionController extends Controller
{
    public function index()
    {
        $transactions = StockTransaction::with('product', 'supplier', 'user')->latest()->get();
        return view('stock-transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('stock-transactions.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out,damage,return',
            'quantity' => 'required|integer|min:1',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'date' => 'required|date',
            'remarks' => 'nullable|string'
        ]);

        $data['recorded_by'] = auth()->id();

        // Update product stock
        $product = Product::find($data['product_id']);
        if ($data['type'] === 'in') {
            $product->stock += $data['quantity'];
        } elseif ($data['type'] === 'out' || $data['type'] === 'damage') {
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
        return view('stock-transactions.show', compact('transaction'));
    }

    public function edit($id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('stock-transactions.edit', compact('transaction', 'products', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $transaction = StockTransaction::findOrFail($id);
        $transaction->update($request->all());
        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction updated successfully');
    }

    public function destroy($id)
    {
        StockTransaction::findOrFail($id)->delete();
        return redirect()->route('stock-transactions.index')->with('success', 'Stock transaction deleted successfully');
    }
}