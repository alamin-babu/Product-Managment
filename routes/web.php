<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect to products if logged in, otherwise to register
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index'); // Redirect to products if logged in
    }
    return view('welcome'); // Redirect to register if not logged in
});

// Custom post-login redirect to products
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('products.index');  // Redirect to products after login
    })->name('dashboard');  // Dashboard route name remains the same

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Protect product-related routes with auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::resource('products', ProductController::class)->except(['create', 'edit', 'index']);
    Route::get('products-data', [ProductController::class, 'getProducts'])->name('products.data');
    Route::get('products/{product}', [ProductController::class, 'getProduct'])->name('products.get');
});

require __DIR__.'/auth.php';
