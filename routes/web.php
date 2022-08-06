<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers');
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('warehouse', [WarehouseController::class, 'index'])->name('warehouse');
    Route::get('income/create', [WarehouseController::class, 'create'])->name('income.create');
    Route::get('income/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('income.edit');
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
