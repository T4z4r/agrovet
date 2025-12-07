<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Supplier::orderBy('name')->get(),
            'message' => 'Suppliers retrieved successfully'
        ]);
    }

    public function store(Request $r)
    {
        return response()->json([
            'success' => true,
            'data' => Supplier::create($r->validate([
                'name'=>'required',
                'contact_person'=>'nullable',
                'phone'=>'nullable',
                'email'=>'nullable|email',
                'address'=>'nullable'
            ])),
            'message' => 'Supplier created successfully'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Supplier::findOrFail($id),
            'message' => 'Supplier retrieved successfully'
        ]);
    }

    public function update(Request $r, $id)
    {
        $s = Supplier::findOrFail($id);
        $s->update($r->all());
        return response()->json([
            'success' => true,
            'data' => $s,
            'message' => 'Supplier updated successfully'
        ]);
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted successfully'
        ]);
    }
}
