<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showAdminLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/cashier/login', [LoginController::class, 'showCashierLoginForm'])->name('cashier.login');
    Route::post('/cashier/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
        Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{stock}', [InventoryController::class, 'show'])->name('inventory.show');
        Route::put('/inventory/{stock}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::post('/inventory/{stock}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
        
        Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
        Route::get('/recipes/export', [RecipeController::class, 'export'])->name('recipes.export');
        Route::post('/recipes/import', [RecipeController::class, 'import'])->name('recipes.import');
        Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
        Route::get('/recipes/{product}', [RecipeController::class, 'show'])->name('recipes.show');
        Route::put('/recipes/{product}', [RecipeController::class, 'update'])->name('recipes.update');
        Route::delete('/recipes/{product}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/sales', [SalesController::class, 'index'])->name('sales');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Cashier\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/orders/check-updates', [App\Http\Controllers\Cashier\DashboardController::class, 'checkNewOrders'])->name('orders.check-updates');
        
        Route::get('/history', [App\Http\Controllers\Cashier\HistoryController::class, 'index'])->name('history');

        // New Order Management Routes
        Route::get('/orders', [App\Http\Controllers\Cashier\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/check-new', [App\Http\Controllers\Cashier\OrderController::class, 'checkUpdates'])->name('orders.check-new');
        Route::patch('/order-items/{item}/status', [App\Http\Controllers\Cashier\OrderController::class, 'updateItemStatus'])->name('order-items.update-status');
        Route::get('/orders/{order}/receipt', [App\Http\Controllers\Cashier\OrderController::class, 'printReceipt'])->name('orders.receipt');

        Route::post('/orders/{order}/confirm-payment', [App\Http\Controllers\Cashier\DashboardController::class, 'confirmPayment'])->name('orders.confirm-payment');
        Route::post('/orders/{order}/process', [App\Http\Controllers\Cashier\DashboardController::class, 'processOrder'])->name('orders.process');
        Route::post('/orders/{order}/ready', [App\Http\Controllers\Cashier\DashboardController::class, 'markReady'])->name('orders.ready');
        Route::post('/orders/{order}/complete', [App\Http\Controllers\Cashier\DashboardController::class, 'completeOrder'])->name('orders.complete');
        Route::post('/orders/{order}/update-status', [App\Http\Controllers\Cashier\DashboardController::class, 'updateStatus'])->name('orders.update-status');
    });

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/', [App\Http\Controllers\Customer\CustomerModeController::class, 'index'])->name('index');
        Route::get('/order', [App\Http\Controllers\Customer\CustomerModeController::class, 'order'])->name('order');
        Route::post('/pre-checkout', [App\Http\Controllers\Customer\CustomerModeController::class, 'preCheckout'])->name('pre-checkout');
        Route::get('/checkout', [App\Http\Controllers\Customer\CustomerModeController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [App\Http\Controllers\Customer\CustomerModeController::class, 'store'])->name('checkout.store');
        Route::get('/payment-process/{order}', [App\Http\Controllers\Customer\CustomerModeController::class, 'paymentProcess'])->name('payment-process');
        Route::get('/orders/{order}/status', [App\Http\Controllers\Customer\CustomerModeController::class, 'checkStatus'])->name('orders.status');
        Route::post('/exit', [App\Http\Controllers\Customer\CustomerModeController::class, 'exit'])->name('exit');
    });
});
