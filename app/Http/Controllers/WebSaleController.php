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

    public function edit($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        $products = Product::orderBy('name')->get();
        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $r, $id)
    {
        $data = $r->validate([
            'sale_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
        ]);

        $sale = Sale::with('items')->findOrFail($id);

        DB::transaction(function () use ($data, $sale) {
            $sale->update([
                'sale_date' => $data['sale_date'],
                'payment_method' => $data['payment_method'],
                'customer_name' => $data['customer_name'],
            ]);

            $existingItemIds = $sale->items->pluck('id')->toArray();
            $submittedItemIds = [];

            $grand_total = 0;

            foreach ($data['items'] as $itemData) {
                $total = $itemData['quantity'] * $itemData['price'];
                $grand_total += $total;

                if (isset($itemData['id']) && in_array($itemData['id'], $existingItemIds)) {
                    // Update existing item
                    $item = SaleItem::find($itemData['id']);
                    $oldProduct = $item->product;
                    $oldQuantity = $item->quantity;

                    $newProduct = Product::find($itemData['product_id']);

                    // Adjust stock
                    if ($oldProduct->id != $newProduct->id) {
                        // Product changed
                        $oldProduct->stock += $oldQuantity;
                        $oldProduct->save();

                        if ($newProduct->stock < $itemData['quantity']) {
                            throw new \Exception('Insufficient stock for ' . $newProduct->name);
                        }
                        $newProduct->stock -= $itemData['quantity'];
                        $newProduct->save();
                    } else {
                        // Same product, quantity changed
                        $quantityDiff = $itemData['quantity'] - $oldQuantity;
                        if ($quantityDiff > 0) {
                            if ($newProduct->stock < $quantityDiff) {
                                throw new \Exception('Insufficient stock for ' . $newProduct->name);
                            }
                            $newProduct->stock -= $quantityDiff;
                        } else {
                            $newProduct->stock += abs($quantityDiff);
                        }
                        $newProduct->save();
                    }

                    $item->update([
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'total' => $total,
                    ]);

                    $submittedItemIds[] = $itemData['id'];
                } else {
                    // New item
                    $product = Product::find($itemData['product_id']);
                    if ($product->stock < $itemData['quantity']) {
                        throw new \Exception('Insufficient stock for ' . $product->name);
                    }

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $itemData['product_id'],
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'total' => $total,
                    ]);

                    $product->stock -= $itemData['quantity'];
                    $product->save();
                }
            }

            // Delete removed items
            $toDelete = array_diff($existingItemIds, $submittedItemIds);
            foreach ($toDelete as $deleteId) {
                $item = SaleItem::find($deleteId);
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
                $item->delete();
            }

            $sale->total = $grand_total;
            $sale->save();
        });

        return redirect()->route('web.sales.index')->with('success', 'Sale updated successfully');
    }

    public function receipt($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);

        $pdf = PDF::loadView('pdf.receipt', compact('sale'));
        return $pdf->download("receipt_{$sale->id}.pdf");
    }
}
