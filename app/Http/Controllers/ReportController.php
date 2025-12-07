<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Expense;

class ReportController extends Controller
{
    public function daily($date)
    {
        return [
            'sales' => Sale::with('items.product','seller')
                ->where('sale_date', $date)->get(),

            'total_sales' => Sale::where('sale_date',$date)->sum('total'),

            'expenses' => Expense::where('date',$date)->get(),

            'total_expenses' => Expense::where('date',$date)->sum('amount')
        ];
    }
}
