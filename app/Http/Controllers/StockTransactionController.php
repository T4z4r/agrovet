<?php
namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransactionController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => StockTransaction::where('shop_id', Auth::user()->shop_id)->with(['product','supplier','user'])
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
        $data['shop_id'] = Auth::user()->shop_id;

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
            'data' => StockTransaction::where('shop_id', Auth::user()->shop_id)->with(['product','supplier','user'])->findOrFail($id),
            'message' => 'Stock transaction retrieved successfully'
        ]);
    }

    public function destroy($id)
    {
        $tx = StockTransaction::where('shop_id', Auth::user()->shop_id)->findOrFail($id);
        $product = $tx->product;

        if ($tx->type === 'stock_in' || $tx->type === 'return') {
            if ($product->stock < $tx->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete transaction: insufficient stock'
                ], 400);
            }
            $product->stock -= $tx->quantity;
        } else {
            $product->stock += $tx->quantity;
        }

        $product->save();
        $tx->delete();

        return response()->json([
            'success' => true,
            'message' => 'Stock transaction deleted successfully'
        ]);
    }
}
