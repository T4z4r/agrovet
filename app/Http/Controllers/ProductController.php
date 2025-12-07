<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::orderBy('name')->get();
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'=>'required',
            'unit'=>'required',
            'stock'=>'required|integer|min:0',
            'cost_price'=>'required|integer|min:0',
            'selling_price'=>'required|integer|min:0'
        ]);

        return Product::create($data);
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }

    public function update(Request $r, $id)
    {
        $p = Product::findOrFail($id);
        $p->update($r->all());
        return $p;
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return ['message' => 'Product deleted'];
    }
}
