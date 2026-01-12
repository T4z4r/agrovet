<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WebSaleController extends Controller
{
    public function index(Request $request)
    {


        if ($request->ajax()) {
            $sales = Sale::with('seller')->latest()->get();
            return response()->json([
                'data' => $sales
            ]);
        }

        $sales = Sale::with('items.product', 'seller')->latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $r)
    {
        $user = Auth::user();
        $data = $r->validate([
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
            'shop_id' => 'nullable|exists:shops,id'
        ]);

        if (!$user->hasRole('superadmin')) {
            $data['shop_id'] = $user->shop_id;
        }

        DB::transaction(function () use ($data) {

            $sale = Sale::create([
                'seller_id' => Auth::user()->id,
                'sale_date' => $data['sale_date'],
                'total' => 0,
                'shop_id' => $data['shop_id']
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
                    throw new \Exception('Insufficient stock for ' . $p->name);
                }

                $p->stock -= $item['quantity'];
                $p->save();
            }

            $sale->total = $grand_total;
            $sale->save();
        });

        return redirect()->route('sales.index')->with('success', 'Sale created successfully');
    }

    public function show($id)
    {
        $sale = Sale::with('items.product', 'seller')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    public function receipt($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        $pdf = PDF::loadView('pdf.receipt', compact('sale'));
        return $pdf->download("receipt_{$sale->id}.pdf");
    }
}
