<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Supplier::where('shop_id', Auth::user()->shop_id)->orderBy('name')->get(),
            'message' => 'Suppliers retrieved successfully'
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'=>'required',
            'contact_person'=>'nullable',
            'phone'=>'nullable',
            'email'=>'nullable|email',
            'address'=>'nullable'
        ]);
        $data['shop_id'] = Auth::user()->shop_id;
        return response()->json([
            'success' => true,
            'data' => Supplier::create($data),
            'message' => 'Supplier created successfully'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Supplier::where('shop_id', Auth::user()->shop_id)->findOrFail($id),
            'message' => 'Supplier retrieved successfully'
        ]);
    }

    public function update(Request $r, $id)
    {
        $s = Supplier::where('shop_id', Auth::user()->shop_id)->findOrFail($id);
        $s->update($r->all());
        return response()->json([
            'success' => true,
            'data' => $s,
            'message' => 'Supplier updated successfully'
        ]);
    }

    public function destroy($id)
    {
        Supplier::where('shop_id', Auth::user()->shop_id)->findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }
}
