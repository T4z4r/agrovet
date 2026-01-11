<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Sale::where('shop_id', Auth::user()->shop_id)->with('items.product', 'seller')->latest()->get(),
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
                'shop_id' => Auth::user()->shop_id,
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

                StockTransaction::create([
                    'product_id' => $item['product_id'],
                    'type' => 'stock_out',
                    'quantity' => $item['quantity'],
                    'supplier_id' => null,
                    'recorded_by' => Auth::user()->id,
                    'shop_id' => Auth::user()->shop_id,
                    'date' => $data['sale_date'],
                    'remarks' => 'Sold in sale #' . $sale->id
                ]);
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
            'data' => Sale::where('shop_id', Auth::user()->shop_id)->with('items.product', 'seller')->findOrFail($id),
            'message' => 'Sale retrieved successfully'
        ]);
    }

    public function receipt($id)
    {
        $sale = Sale::where('shop_id', Auth::user()->shop_id)->with('items.product')->findOrFail($id);

        $pdf = PDF::loadView('pdf.receipt', compact('sale'));
        return $pdf->download("receipt_{$sale->id}.pdf");
    }

    public function destroy($id)
    {
        if (!in_array(auth()->user()->role, ['admin', 'owner'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $sale = Sale::where('shop_id', Auth::user()->shop_id)->with('items.product')->findOrFail($id);

        return DB::transaction(function () use ($sale) {
            // Restore stock and create stock transactions
            foreach ($sale->items as $item) {
                $item->product->stock += $item->quantity;
                $item->product->save();

                StockTransaction::create([
                    'product_id' => $item->product_id,
                    'type' => 'stock_in',
                    'quantity' => $item->quantity,
                    'supplier_id' => null,
                    'recorded_by' => auth()->id(),
                    'shop_id' => Auth::user()->shop_id,
                    'date' => $sale->sale_date,
                    'remarks' => 'Restored from deleted sale #' . $sale->id
                ]);
            }

            // Delete sale items
            $sale->items()->delete();

            // Delete sale
            $sale->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sale deleted successfully'
            ]);
        });
    }
}
