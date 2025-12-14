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
            'stock'=>'required|integer|min:0',
            'cost_price'=>'required|min:0',
            'selling_price'=>'required|min:0'
        ]);

        return response()->json([
            'success' => true,
            'data' => Product::create($data),
            'message' => 'Product created successfully'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Product::findOrFail($id),
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
}
