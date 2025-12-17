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
use Carbon\Carbon;


class WebSaleController extends Controller
{
    public function index(Request $request)
    {

$test = Sale::whereDate('sale_date', Carbon::today())->sum('total');
        dd($test);
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
        $data = $r->validate([
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0'
        ]);

        DB::transaction(function () use ($data) {

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
