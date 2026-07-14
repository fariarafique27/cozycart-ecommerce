<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProductController as ShopProductController;
use App\Http\Controllers\CategoryController;
use App\Models\Product;

Route::get('/', function () {
    // 🧸 2. Fetch the latest plushies from your database table
    $products = Product::latest()->take(6)->get(); 

    // 📥 3. Pass that variable directly into your welcome view
    return view('welcome', compact('products'));
});


Route::get('/products', [ShopProductController::class, 'index'])->name('shop.index');
Route::get('/product/{product}', [ShopProductController::class, 'show'])->name('shop.show');


// 👥 Guest Routes (Login / Registration)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// 🔒 Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Customer Storefront Dashboard


    // 👑 Admin Panel (Guarded by our custom middleware!)
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            
            Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');
            
            Route::resource('products', ProductController::class);

            //Add category 
            Route::get('/categories' , [CategoryController::class , 'index' ])->name('categories');
            Route::post('/categories' , [CategoryController::class , 'store' ])->name('categories.store');
        });
});