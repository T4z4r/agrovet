<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Expense::with('shop', 'recordedBy');
        if (!$user->hasRole('superadmin')) {
            $query->where('shop_id', $user->shop_id);
        }
        $expenses = $query->latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $user = Auth::user();
        if ($user->hasRole('superadmin')) {
            $shops = Shop::all();
        } else {
            $shops = Shop::where('id', $user->shop_id)->get();
        }
        return view('expenses.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'shop_id' => 'nullable|exists:shops,id',
            'category' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date'
        ]);

        if (!$user->hasRole('superadmin')) {
            $data['shop_id'] = $user->shop_id;
        }

        $data['recorded_by'] = auth()->id();

        Expense::create($data);

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully');
    }

    public function show($id)
    {
        $expense = Expense::with('shop', 'recordedBy')->findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $expense->shop_id != $user->shop_id) {
            abort(403);
        }
        return view('expenses.show', compact('expense'));
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $expense->shop_id != $user->shop_id) {
            abort(403);
        }
        if ($user->hasRole('superadmin')) {
            $shops = Shop::all();
        } else {
            $shops = Shop::where('id', $user->shop_id)->get();
        }
        return view('expenses.edit', compact('expense', 'shops'));
    }

    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $expense->shop_id != $user->shop_id) {
            abort(403);
        }
        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('superadmin') && $expense->shop_id != $user->shop_id) {
            abort(403);
        }
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully');
    }
}