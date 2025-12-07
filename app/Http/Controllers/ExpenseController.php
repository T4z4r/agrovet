<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Expense::with('user')->orderBy('date','desc')->get(),
            'message' => 'Expenses retrieved successfully'
        ]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'category'=>'required|string',
            'amount'=>'required|integer|min:0',
            'description'=>'nullable|string',
            'date'=>'required|date'
        ]);

        $data['recorded_by'] = $r->user()->id;
        return response()->json([
            'success' => true,
            'data' => Expense::create($data),
            'message' => 'Expense created successfully'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Expense::with('user')->findOrFail($id),
            'message' => 'Expense retrieved successfully'
        ]);
    }

    public function update(Request $r, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($r->all());
        return response()->json([
            'success' => true,
            'data' => $expense,
            'message' => 'Expense updated successfully'
        ]);
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Expense deleted successfully'
        ]);
    }
}
