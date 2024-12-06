<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('products/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('products/store', [ProductsController::class, 'store'])->name('products.store');
Route::get('products/index', [ProductsController::class, 'index'])->name('products.index');
Route::POST('products/edit/{id}', [ProductsController::class, 'edit']);
Route::POST('products/update', [ProductsController::class, 'update'])->name('products.update');
Route::get('products/get_data', [ProductsController::class, 'get_data'])->name('products.get_data');
