<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WebPosController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();
        return view('pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_method' => 'nullable|string',
            'customer_name' => 'nullable|string'
        ]);

        DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'seller_id' => Auth::user()->id,
                'sale_date' => now(),
                'total' => 0,
                'payment_method' => $data['payment_method'] ?? null,
                'customer_name' => $data['customer_name'] ?? null
            ]);

            $grand_total = 0;

            foreach ($data['items'] as $item) {
                $total = $item['quantity'] * $item['price'];
                $grand_total += $total;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total
                ]);

                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Insufficient stock for ' . $product->name);
                }

                $product->stock -= $item['quantity'];
                $product->save();
            }

            $sale->total = $grand_total;
            $sale->save();
        });

        return response()->json(['success' => true, 'message' => 'Sale completed successfully']);
    }

    public function receipt($id)
    {
        $sale = Sale::with('items.product', 'seller')->findOrFail($id);
        return view('pos.receipt', compact('sale'));
    }
}
