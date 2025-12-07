<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        return Sale::with('items.product','seller')->latest()->get();
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'seller_id'=>'required|exists:users,id',
            'sale_date'=>'required|date',
            'items'=>'required|array|min:1',
            'items.*.product_id'=>'required|exists:products,id',
            'items.*.quantity'=>'required|integer|min:1',
            'items.*.price'=>'required|integer|min:0'
        ]);

        return DB::transaction(function() use ($data) {

            $sale = Sale::create([
                'seller_id'=>$data['seller_id'],
                'sale_date'=>$data['sale_date'],
                'total'=>0
            ]);

            $grand_total = 0;

            foreach ($data['items'] as $item) {

                $total = $item['quantity'] * $item['price'];
                $grand_total += $total;

                SaleItem::create([
                    'sale_id'=>$sale->id,
                    'product_id'=>$item['product_id'],
                    'quantity'=>$item['quantity'],
                    'price'=>$item['price'],
                    'total'=>$total
                ]);

                $p = Product::find($item['product_id']);
                if ($p->stock < $item['quantity']) {
                    abort(422, 'Insufficient stock for '.$p->name);
                }

                $p->stock -= $item['quantity'];
                $p->save();
            }

            $sale->total = $grand_total;
            $sale->save();

            return $sale->load('items.product');
        });
    }

    public function show($id)
    {
        return Sale::with('items.product','seller')->findOrFail($id);
    }
}
