<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

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
    Route::post('sales', [SaleController::class, 'store']);
    Route::get('sales', [SaleController::class, 'index']);
    Route::get('sales/{id}', [SaleController::class, 'show']);
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
    Route::get('reports/profit/{start}/{end}', [ReportController::class, 'profit']);
    Route::get('reports/dashboard', [ReportController::class, 'dashboard']);

});
