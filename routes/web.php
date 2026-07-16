<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminStatsController; // 📊 Imported for Analytics!
use App\Http\Controllers\ProductController as ShopProductController;
use App\Http\Controllers\CategoryController;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;   
use Illuminate\Support\Facades\Mail;

// 🧸 Welcome Landing Page
Route::get('/', function () {
    $products = Product::latest()->take(6)->get(); 
    return view('welcome', compact('products'));
});

// 🛒 Shopping Cart System Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// 💳 Checkout Engine Route (Clean and unique, outside any groups!)
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// 🛍️ Public Store Browsing Pages
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
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
         
    // 👑 Admin Panel Group (Guarded by authentication & your custom Admin middleware)
    Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Admin Home Layout Dashboard
            Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');
            
            // 📊 Admin Business Analytics Dashboard (Daily/Monthly sales metrics here!)
            Route::get('/analytics', [AdminStatsController::class, 'index'])->name('analytics');
            Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
              // Standard Product Management Resource
            Route::resource('products', ProductController::class);

            // Product Inventory Categories Management 
            Route::get('/categories' , [CategoryController::class , 'index' ])->name('categories');
            Route::post('/categories' , [CategoryController::class , 'store' ])->name('categories.store');
            Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); 
            Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); 
              });
});
