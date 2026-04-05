<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebSupplierController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Supplier::query();
        if (!$user->hasRole('superadmin')) {
            $query->where('shop_id', $user->shop_id);
        }
        if ($request->ajax()) {
            $suppliers = $query->orderBy('name')->get();
            return response()->json([
                'data' => $suppliers
            ]);
        }

        $suppliers = $query->orderBy('name')->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'shop_id' => 'nullable|exists:shops,id'
        ]);

        if (!$user->hasRole('superadmin')) {
            $data['shop_id'] = $user->shop_id;
        }

        Supplier::create($data);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully');
    }

    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $supplier->shop_id != $user->shop_id) {
            abort(403);
        }
        return view('suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $supplier->shop_id != $user->shop_id) {
            abort(403);
        }
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $supplier->shop_id != $user->shop_id) {
            abort(403);
        }
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'shop_id' => 'nullable|exists:shops,id'
        ]);
        $supplier->update($data);
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $supplier->shop_id != $user->shop_id) {
            abort(403);
        }
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully');
    }
}
