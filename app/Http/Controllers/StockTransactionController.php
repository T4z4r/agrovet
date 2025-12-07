<?php
namespace App\Http\Controllers;

use App\Models\StockTransaction;
use App\Models\Product;
use Illuminate\Http\Request;

class StockTransactionController extends Controller
{
    public function index()
    {
        return StockTransaction::with(['product','supplier','user'])
            ->orderBy('date','desc')->get();
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
        $tx = StockTransaction::create($data);

        $product = Product::find($data['product_id']);

        if ($data['type'] === 'stock_in' || $data['type'] === 'return') {
            $product->stock += $data['quantity'];
        } else {
            $product->stock -= $data['quantity'];
        }

        $product->save();

        return $tx;
    }

    public function show($id)
    {
        return StockTransaction::with(['product','supplier','user'])->findOrFail($id);
    }

    public function destroy($id)
    {
        StockTransaction::findOrFail($id)->delete();
        return ['message'=>'Record deleted'];
    }
}
