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
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
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
});
