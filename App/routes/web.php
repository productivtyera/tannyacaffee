<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{stock}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::put('/inventory/{stock}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::post('/inventory/{stock}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});
