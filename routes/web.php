<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\WebProductController;
use App\Http\Controllers\WebSupplierController;
use App\Http\Controllers\WebUserController;
use App\Http\Controllers\WebShopController;
use App\Http\Controllers\WebBranchController;
use App\Http\Controllers\WebSaleController;
use App\Http\Controllers\WebExpenseController;
use App\Http\Controllers\WebStockTransactionController;
use App\Http\Controllers\WebSupplierDebtController;
use App\Http\Controllers\WebReportController;
use App\Http\Controllers\WebAdminController;
use App\Http\Controllers\WebBrandController;
use App\Http\Controllers\WebPermissionController;
use App\Http\Controllers\WebPosController;
use App\Http\Controllers\WebRoleController;
use App\Http\Controllers\WebPrivacyPolicyController;
use App\Http\Controllers\WebSubscriptionPackageController;
use App\Http\Controllers\WebSubscriptionController;
use App\Http\Controllers\WebSubscriptionPaymentController;
use App\Http\Controllers\WebFeatureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;

/*p
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
    // Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    // Route::post('/register', [WebAuthController::class, 'register');
});

// Public routes
Route::get('/privacy-policy', [WebPrivacyPolicyController::class, 'publicShow'])->name('privacy-policy.public');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');

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
    Route::patch('users/{user}/block', [WebUserController::class, 'block'])->name('web.users.block');
    Route::get('users/{user}/seller-report', [WebUserController::class, 'sellerReport'])->name('web.users.sellerReport');
    Route::get('users/{user}/roles', [WebUserController::class, 'roles'])->name('web.users.roles');
    Route::post('users/{user}/assign-role', [WebUserController::class, 'assignRole'])->name('web.users.assignRole');
    Route::delete('users/{userId}/remove-role/{roleId}', [WebUserController::class, 'removeRole'])->name('web.users.removeRole');
    Route::get('users/{user}/permissions', [WebUserController::class, 'permissions'])->name('web.users.permissions');
    Route::post('users/{user}/give-permission', [WebUserController::class, 'givePermission'])->name('web.users.givePermission');
    Route::delete('users/{userId}/revoke-permission/{permissionId}', [WebUserController::class, 'revokePermission'])->name('web.users.revokePermission');

    // Roles Management
    Route::resource('roles', WebRoleController::class)->parameters(['roles' => 'role'])->names('web.roles');

    // Permissions Management
    Route::resource('permissions', WebPermissionController::class)->parameters(['permissions' => 'permission'])->names('web.permissions');

    // Privacy Policies
    Route::resource('privacy-policies', WebPrivacyPolicyController::class)->parameters(['privacy-policies' => 'privacyPolicy'])->names('web.privacy-policies');

    // Shops
    Route::resource('shops', WebShopController::class)->names('web.shops');

    // Branches
    Route::resource('branches', WebBranchController::class)->names('web.branches');

    // Sales
    Route::resource('sales', WebSaleController::class)->except(['edit', 'update'])->names('web.sales');
    Route::get('sales/{sale}/receipt', [WebSaleController::class, 'receipt'])->name('web.sales.receipt');

    // POS
    Route::middleware('auth')->group(function () {
        Route::get('pos', [WebPosController::class, 'index'])->name('web.pos.index');
        Route::post('pos', [WebPosController::class, 'store'])->name('web.pos.store');
        Route::get('pos/receipt/{id}', [WebPosController::class, 'receipt'])->name('web.pos.receipt');
    });

    // Expenses
    Route::resource('expenses', WebExpenseController::class)->names('web.expenses');

    // Stock Transactions
    Route::resource('stock-transactions', WebStockTransactionController::class)->parameters(['stock-transactions' => 'stockTransaction'])->names('web.stock-transactions');

    // Supplier Debts
    Route::resource('supplier-debts', WebSupplierDebtController::class)->parameters(['supplier-debts' => 'supplierDebt'])->names('web.supplier-debts');

    // Reports
    Route::get('reports', [WebReportController::class, 'index'])->name('web.reports.index');
    Route::get('reports/daily', [WebReportController::class, 'daily'])->name('web.reports.daily');
    Route::get('reports/profit', [WebReportController::class, 'profit'])->name('web.reports.profit');
    Route::get('reports/dashboard', [WebReportController::class, 'dashboard'])->name('web.reports.dashboard');
    Route::get('reports/seller/day-summary', [WebReportController::class, 'sellerDaySummary'])->name('web.reports.seller.day-summary');

    // Admin
    Route::get('admin', [WebAdminController::class, 'index'])->name('web.admin.index');
    Route::post('admin/clear/{table}', [WebAdminController::class, 'clear'])->name('web.admin.clear');

    // Subscription Packages
    Route::resource('admin/subscription-packages', WebSubscriptionPackageController::class)->names('admin.subscription-packages');

    // Subscriptions
    Route::resource('admin/subscriptions', WebSubscriptionController::class)->names('admin.subscriptions');

    // Subscription Payments
    Route::resource('admin/subscription-payments', WebSubscriptionPaymentController::class)->names('admin.subscription-payments');

    // Features
    Route::resource('admin/features', WebFeatureController::class)->names('admin.features');
});
