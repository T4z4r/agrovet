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
use PDF;

class ReportController extends Controller
{
    public function daily($date)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'sales' => Sale::with('items.product', 'seller')
                    ->where('sale_date', $date)->get(),

                'total_sales' => Sale::where('sale_date', $date)->sum('total'),

                'expenses' => Expense::where('date', $date)->get(),

                'total_expenses' => Expense::where('date', $date)->sum('amount')
            ],
            'message' => 'Daily report retrieved successfully'
        ]);
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

        return response()->json([
            'success' => true,
            'data' => [
                'revenue' => $total_revenue,
                'cost'    => $total_cost,
                'profit'  => $total_revenue - $total_cost,
            ],
            'message' => 'Profit report retrieved successfully'
        ]);
    }

    public function dashboard()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_products'  => Product::count(),
                'total_sales'     => Sale::sum('total'),
                'total_expenses'  => Expense::sum('amount'),
                'today_sales'     => Sale::whereDate('sale_date', today())->sum('total'),
                'stock_value'     => Product::sum(DB::raw('cost_price * stock')),
                'low_stock_products_count' => Product::whereRaw('stock <= minimum_quantity')->count(),
            ],
            'message' => 'Dashboard data retrieved successfully'
        ]);
    }

    public function sellerDaySummary(Request $request, $date = null)
    {
        $user = Auth::user();
        $date = $date ?? today()->toDateString();

        $sales = Sale::with('items.product')
            ->where('seller_id', Auth::user()->id)
            ->where('sale_date', $date)
            ->get();

        $totalSales = $sales->sum('total');

        $expenses = Expense::where('recorded_by', $user->id)
            ->where('date', $date)
            ->get();

        $totalExpenses = $expenses->sum('amount');

        $stockTransactions = StockTransaction::with('product', 'supplier')
            ->where('recorded_by', $user->id)
            ->where('date', $date)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'date' => $date,
                'sales' => $sales,
                'total_sales' => $totalSales,
                'expenses' => $expenses,
                'total_expenses' => $totalExpenses,
                'stock_transactions' => $stockTransactions,
            ],
            'message' => 'Seller day summary retrieved successfully'
        ]);
    }
}
