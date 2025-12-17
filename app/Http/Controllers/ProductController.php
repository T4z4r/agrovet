<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
            'barcode'=>'nullable|string'
        ]);

        return response()->json([
            'success' => true,
            'data' => Product::create($data),
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
        $p->update($r->all());
        return response()->json([
            'success' => true,
            'data' => $p,
            'message' => 'Product updated successfully'
        ]);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
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
