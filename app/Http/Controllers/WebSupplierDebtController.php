<?php

namespace App\Http\Controllers;

use App\Models\SupplierDebt;
use App\Models\Supplier;
use Illuminate\Http\Request;

class WebSupplierDebtController extends Controller
{
    public function index()
    {
        $debts = SupplierDebt::with('supplier')->latest()->get();
        return view('supplier-debts.index', compact('debts'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        return view('supplier-debts.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'paid' => 'boolean',
            'date' => 'required|date'
        ]);

        SupplierDebt::create($data);

        return redirect()->route('supplier-debts.index')->with('success', 'Supplier debt created successfully');
    }

    public function show($id)
    {
        $debt = SupplierDebt::with('supplier')->findOrFail($id);
        return view('supplier-debts.show', compact('debt'));
    }

    public function edit($id)
    {
        $debt = SupplierDebt::findOrFail($id);
        $suppliers = Supplier::orderBy('name')->get();
        return view('supplier-debts.edit', compact('debt', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $debt = SupplierDebt::findOrFail($id);
        $debt->update($request->all());
        return redirect()->route('supplier-debts.index')->with('success', 'Supplier debt updated successfully');
    }

    public function destroy($id)
    {
        SupplierDebt::findOrFail($id)->delete();
        return redirect()->route('supplier-debts.index')->with('success', 'Supplier debt deleted successfully');
    }
}