<?php
namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => StockTransaction::with(['product','supplier','user'])
                ->orderBy('date','desc')->get(),
            'message' => 'Stock transactions retrieved successfully'
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'product_id'=>'required|exists:products,id',
            'type'=>'required|in:stock_in,stock_out,damage,return',
            'quantity'=>'required|integer|min:1',
            'supplier_id'=>'nullable|exists:suppliers,id',
            'date'=>'required|date',
            'remarks'=>'nullable|string'
        ]);

        $data['recorded_by'] = $r->user()->id;

        $product = Product::find($data['product_id']);

        if ($data['type'] === 'stock_in' || $data['type'] === 'return') {
            $product->stock += $data['quantity'];
        } else {
            if ($product->stock < $data['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock'
                ], 400);
            }
            $product->stock -= $data['quantity'];
        }

        $product->save();

        $tx = StockTransaction::create($data);

        return response()->json([
            'success' => true,
            'data' => $tx,
            'message' => 'Stock transaction created successfully'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => StockTransaction::with(['product','supplier','user'])->findOrFail($id),
            'message' => 'Stock transaction retrieved successfully'
        ]);
    }

    public function destroy($id)
    {
        StockTransaction::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Stock transaction deleted successfully'
        ]);
    }
}
