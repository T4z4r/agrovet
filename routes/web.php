<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebProductController;
use App\Http\Controllers\WebSupplierController;
use App\Http\Controllers\WebUserController;
use App\Http\Controllers\WebShopController;
use App\Http\Controllers\WebSaleController;
use App\Http\Controllers\WebExpenseController;
use App\Http\Controllers\WebStockTransactionController;
use App\Http\Controllers\WebSupplierDebtController;
use App\Http\Controllers\WebReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard');

    // Language switch
    Route::get('/lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'sw'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    })->name('lang.switch');

    // Products
    Route::resource('products', WebProductController::class)->names('web.products');

    // Suppliers
    Route::resource('suppliers', WebSupplierController::class)->names('web.suppliers');

    // Users (Sellers)
    Route::resource('users', WebUserController::class)->parameters(['users' => 'user'])->names('web.users');

    // Shops
    Route::resource('shops', WebShopController::class)->names('web.shops');

    // Sales
    Route::resource('sales', WebSaleController::class)->except(['edit', 'update'])->names('web.sales');

    // Expenses
    Route::resource('expenses', WebExpenseController::class)->names('web.expenses');

    // Stock Transactions
    Route::resource('stock-transactions', WebStockTransactionController::class)->parameters(['stock-transactions' => 'stockTransaction'])->names('web.stock-transactions');

    // Supplier Debts
    Route::resource('supplier-debts', WebSupplierDebtController::class)->parameters(['supplier-debts' => 'supplierDebt'])->names('web.supplier-debts');

    // Reports
    Route::get('reports', [WebReportController::class, 'index'])->name('web.reports.index');
    Route::get('reports/daily/{date}', [WebReportController::class, 'daily'])->name('web.reports.daily');
    Route::get('reports/profit/{start}/{end}', [WebReportController::class, 'profit'])->name('web.reports.profit');
    Route::get('reports/dashboard', [WebReportController::class, 'dashboard'])->name('web.reports.dashboard');
    Route::get('reports/seller/day-summary/{date?}', [WebReportController::class, 'sellerDaySummary'])->name('web.reports.seller.day-summary');
});
