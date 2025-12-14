<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebProductController;
use App\Http\Controllers\WebSupplierController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => Auth::check() ? redirect()->route('dashboard') : redirect()->route('login'));

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', WebProductController::class);
    Route::resource('suppliers', WebSupplierController::class);
});

require __DIR__.'/auth.php';
