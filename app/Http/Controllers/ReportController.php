<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function daily($date)
    {
        return [
            'sales' => Sale::with('items.product', 'seller')
                ->where('sale_date', $date)->get(),

            'total_sales' => Sale::where('sale_date', $date)->sum('total'),

            'expenses' => Expense::where('date', $date)->get(),

            'total_expenses' => Expense::where('date', $date)->sum('amount')
        ];
    }

    public function profit($start, $end)
    {
        $sales = SaleItem::whereBetween('created_at', [$start, $end])
            ->with('product')
            ->get();

        $total_revenue = $sales->sum('total');
        $total_cost = $sales->sum(function ($item) {
            return $item->product->cost_price * $item->quantity;
        });

        return [
            'revenue' => $total_revenue,
            'cost'    => $total_cost,
            'profit'  => $total_revenue - $total_cost,
        ];
    }

    public function dashboard()
    {
        return [
            'total_products'  => Product::count(),
            'total_sales'     => Sale::sum('total'),
            'total_expenses'  => Expense::sum('amount'),
            'today_sales'     => Sale::whereDate('sale_date', today())->sum('total'),
            'stock_value'     => Product::sum(DB::raw('cost_price * stock')),
        ];
    }
}
