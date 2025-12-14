<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebProductController;
use App\Http\Controllers\WebSupplierController;
// Add other controllers as needed

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [WebAuthController::class, 'login']);
    Route::get('register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('register', [WebAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard');

    Route::resource('products', WebProductController::class);
    Route::resource('suppliers', WebSupplierController::class);
    // Add other resources as controllers are created
    // Route::resource('stock', WebStockTransactionController::class);
    // Route::get('sales', [WebSaleController::class, 'index']);
    // Route::get('sales/{id}', [WebSaleController::class, 'show']);
    // Route::resource('expenses', WebExpenseController::class);
    // Route::get('reports/dashboard', [WebReportController::class, 'dashboard']);
    // Route::get('reports/daily/{date}', [WebReportController::class, 'daily']);
    // Route::get('reports/profit/{start}/{end}', [WebReportController::class, 'profit']);
    // Route::resource('users', WebUserController::class)->middleware('role:owner');
});
