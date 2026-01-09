<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Product::orderBy('name')->get(),
            'message' => 'Products retrieved successfully'
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'=>'required',
            'unit'=>'required',
            'category'=>'required',
            'stock'=>'required|min:0',
            'cost_price'=>'required|min:0',
            'selling_price'=>'required|min:0',
            'minimum_quantity'=>'nullable|numeric|min:0',
            'barcode'=>'nullable|string',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($r->hasFile('photo')) {
            $path = $r->file('photo')->store('products', 'public');
            $data['photo'] = $path;
        }

        $product = Product::create($data);

        // Create stock transaction if initial stock > 0
        if ($data['stock'] > 0) {
            StockTransaction::create([
                'product_id' => $product->id,
                'type' => 'stock_in',
                'quantity' => $data['stock'],
                'supplier_id' => null,
                'recorded_by' => Auth::id(),
                'date' => now()->toDateString(),
                'remarks' => 'Initial stock on product creation'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully'
        ]);
    }

    public function show($id)
    {
        $product = Product::with('stockTransactions.supplier', 'stockTransactions.user')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ]);
    }

    public function update(Request $r, $id)
    {
        $p = Product::findOrFail($id);
        $oldStock = $p->stock;

        $p->update($r->all());
        $newStock = $p->stock;

        // Create stock transaction if stock changed
        $stockDifference = $newStock - $oldStock;
        if ($stockDifference != 0) {
            StockTransaction::create([
                'product_id' => $p->id,
                'type' => $stockDifference > 0 ? 'stock_in' : 'stock_out',
                'quantity' => abs($stockDifference),
                'supplier_id' => null,
                'recorded_by' => Auth::id(),
                'date' => now()->toDateString(),
                'remarks' => 'Stock adjustment on product update'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $p,
            'message' => 'Product updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Check if product is linked to sales
        if ($product->saleItems()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product that has been sold'
            ], 422);
        }

        // Check if product has stock transactions
        if ($product->stockTransactions()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product that has stock transactions'
            ], 422);
        }

        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    public function getByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ]);
    }
}
