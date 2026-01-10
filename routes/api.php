<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PrivacyPolicyController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('about', [AboutController::class, 'index']);
Route::get('contacts', [ContactController::class, 'index']);
Route::apiResource('privacy-policies', PrivacyPolicyController::class);

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */
    Route::apiResource('products', ProductController::class);
    Route::get('products/barcode/{barcode}', [ProductController::class, 'getByBarcode']);

    /*
    |--------------------------------------------------------------------------
    | Suppliers
    |--------------------------------------------------------------------------
    */
    Route::apiResource('suppliers', SupplierController::class);

    /*
    |--------------------------------------------------------------------------
    | Stock Transactions (Stock In, Stock Out, Damage, Returns)
    |--------------------------------------------------------------------------
    */
    Route::apiResource('stock', StockTransactionController::class);

    /*
    |--------------------------------------------------------------------------
    | Sales (multi item)
    |--------------------------------------------------------------------------
    */
    Route::apiResource('sales', SaleController::class)->except(['update']);
    Route::get('sales/{id}/receipt', [SaleController::class, 'receipt']);

    /*
    |--------------------------------------------------------------------------
    | Expenses
    |--------------------------------------------------------------------------
    */
    Route::apiResource('expenses', ExpenseController::class);

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */
    Route::get('reports/daily/{date}', [ReportController::class, 'daily']);
    Route::get('reports/daily/{date}/pdf', [ReportController::class, 'dailyPdf']);
    Route::get('reports/profit/{start}/{end}', [ReportController::class, 'profit']);
    Route::get('reports/dashboard', [ReportController::class, 'dashboard']);
    Route::get('reports/seller/day-summary/{date?}', [ReportController::class, 'sellerDaySummary']);

    /*
    |--------------------------------------------------------------------------
    | Sellers (Owner only)
    |--------------------------------------------------------------------------
    */
    Route::apiResource('sellers', UserController::class);
    Route::patch('sellers/{id}/block', [UserController::class, 'block']);
    Route::get('sellers/{id}/report', [UserController::class, 'sellerReport']);

});
