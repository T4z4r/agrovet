<?php
namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return Expense::with('user')->orderBy('date','desc')->get();
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
        return Expense::create($data);
    }

    public function show($id)
    {
        return Expense::with('user')->findOrFail($id);
    }

    public function update(Request $r, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($r->all());
        return $expense;
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return ['message'=>'Expense deleted'];
    }
}
