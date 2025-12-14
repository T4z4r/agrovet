<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Shop;
use Illuminate\Http\Request;

class WebExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('shop', 'recordedBy')->latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $shops = Shop::all();
        return view('expenses.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date'
        ]);

        $data['recorded_by'] = auth()->id();

        Expense::create($data);

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully');
    }

    public function show($id)
    {
        $expense = Expense::with('shop', 'recordedBy')->findOrFail($id);
        return view('expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $shops = Shop::all();
        return view('expenses.edit', compact('expense', 'shops'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully');
    }
}