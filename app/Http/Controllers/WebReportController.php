<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WebReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function daily($date)
    {
        $sales = Sale::with('items.product', 'seller')
            ->where('sale_date', $date)->get();

        $total_sales = Sale::where('sale_date', $date)->sum('total');

        $expenses = Expense::where('date', $date)->get();

        $total_expenses = Expense::where('date', $date)->sum('amount');

        return view('reports.daily', compact('sales', 'total_sales', 'expenses', 'total_expenses', 'date'));
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

        $profit = $total_revenue - $total_cost;

        return view('reports.profit', compact('total_revenue', 'total_cost', 'profit', 'start', 'end'));
    }

    public function dashboard()
    {
        $data = [
            'total_products'  => Product::count(),
            'total_sales'     => Sale::sum('total'),
            'total_expenses'  => Expense::sum('amount'),
            'today_sales'     => Sale::whereDate('sale_date', today())->sum('total'),
            'stock_value'     => Product::sum(DB::raw('cost_price * stock')),
        ];

        return view('reports.dashboard', compact('data'));
    }

    public function sellerDaySummary($date = null)
    {
        $user = Auth::user();
        $date = $date ?? today()->toDateString();

        $sales = Sale::with('items.product')
            ->where('seller_id', Auth::user()->id)
            ->where('sale_date', $date)
            ->get();

        $total_sales = $sales->sum('total');

        $expenses = Expense::where('recorded_by', $user->id)
            ->where('date', $date)
            ->get();

        $total_expenses = $expenses->sum('amount');

        $stock_transactions = StockTransaction::with('product', 'supplier')
            ->where('recorded_by', $user->id)
            ->where('date', $date)
            ->get();

        return view('reports.seller-day-summary', compact('date', 'sales', 'total_sales', 'expenses', 'total_expenses', 'stock_transactions'));
    }
}