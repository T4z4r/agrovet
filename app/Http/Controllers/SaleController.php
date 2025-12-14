<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Sale::with('items.product', 'seller')->latest()->get(),
            'message' => 'Sales retrieved successfully'
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            // 'seller_id' => 'required|exists:users,id',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0'
        ]);

        return DB::transaction(function () use ($data) {

            $sale = Sale::create([
                'seller_id' => Auth::user()->id,
                'sale_date' => $data['sale_date'],
                'total' => 0
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

                $p = Product::find($item['product_id']);
                if ($p->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Insufficient stock for ' . $p->name
                    ], 422);
                }

                $p->stock -= $item['quantity'];
                $p->save();
            }

            $sale->total = $grand_total;
            $sale->save();

            return response()->json([
                'success' => true,
                'data' => $sale->load('items.product'),
                'message' => 'Sale created successfully'
            ]);
        });
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Sale::with('items.product', 'seller')->findOrFail($id),
            'message' => 'Sale retrieved successfully'
        ]);
    }

    public function receipt($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        $pdf = PDF::loadView('pdf.receipt', compact('sale'));
        return $pdf->download("receipt_{$sale->id}.pdf");
    }
}
