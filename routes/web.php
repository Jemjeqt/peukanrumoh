<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Pedagang Controllers
use App\Http\Controllers\Pedagang\DashboardController as PedagangDashboardController;
use App\Http\Controllers\Pedagang\ProductController as PedagangProductController;
use App\Http\Controllers\Pedagang\OrderController as PedagangOrderController;
use App\Http\Controllers\Pedagang\ReturnController as PedagangReturnController;
use App\Http\Controllers\Pedagang\ReviewController as PedagangReviewController;

// Kurir Controllers
use App\Http\Controllers\Kurir\DashboardController as KurirDashboardController;
use App\Http\Controllers\Kurir\DeliveryController as KurirDeliveryController;
use App\Http\Controllers\Kurir\ReturnController as KurirReturnController;

// Pembeli Controllers
use App\Http\Controllers\Pembeli\OrderHistoryController as PembeliOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Guest routes (login, register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Shop routes (for pembeli)
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    
    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment/confirm', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/pay/{order}', [CheckoutController::class, 'payOrder'])->name('checkout.pay-order');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Pembeli Order History routes
    Route::prefix('orders')->name('pembeli.orders.')->group(function () {
        Route::get('/', [PembeliOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [PembeliOrderController::class, 'show'])->name('show');
        Route::post('/{order}/review', [PembeliOrderController::class, 'storeReview'])->name('review');
        Route::get('/{order}/return', [PembeliOrderController::class, 'createReturn'])->name('return');
        Route::post('/{order}/return', [PembeliOrderController::class, 'storeReturn'])->name('return.store');
        Route::post('/{order}/confirm-replacement', [PembeliOrderController::class, 'confirmReplacement'])->name('confirm-replacement');
        Route::post('/{order}/confirm-refund', [PembeliOrderController::class, 'confirmRefund'])->name('confirm-refund');
        Route::post('/{order}/confirm-delivery', [PembeliOrderController::class, 'confirmDelivery'])->name('confirm-delivery');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Product monitoring (read-only)
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    
    // User management
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    
    // Order management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    
    // Return management
    Route::get('/returns', [App\Http\Controllers\Admin\ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{return}', [App\Http\Controllers\Admin\ReturnController::class, 'show'])->name('returns.show');
    
    // Reviews (laporan ulasan)
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    
    // Report Export
    Route::get('/report/export', [AdminDashboardController::class, 'exportReport'])->name('report.export');
});

// Pedagang routes
Route::middleware(['auth', 'pedagang', 'approved'])->prefix('pedagang')->name('pedagang.')->group(function () {
    Route::get('/dashboard', [PedagangDashboardController::class, 'index'])->name('dashboard');
    
    // Product management
    Route::resource('products', PedagangProductController::class);
    
    // Order management
    Route::get('/orders', [PedagangOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PedagangOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/process', [PedagangOrderController::class, 'process'])->name('orders.process');
    Route::post('/orders/{order}/ready-pickup', [PedagangOrderController::class, 'readyPickup'])->name('orders.ready-pickup');
    
    // Return management
    Route::get('/returns', [PedagangReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{return}', [PedagangReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{return}/approve', [PedagangReturnController::class, 'approve'])->name('returns.approve');
    Route::post('/returns/{return}/reject', [PedagangReturnController::class, 'reject'])->name('returns.reject');
    Route::post('/returns/{return}/send-replacement', [PedagangReturnController::class, 'sendReplacement'])->name('returns.send-replacement');
    Route::post('/returns/{return}/send-refund', [PedagangReturnController::class, 'sendRefund'])->name('returns.send-refund');
    
    // Reviews
    Route::get('/reviews', [PedagangReviewController::class, 'index'])->name('reviews.index');
    
    // Report Export
    Route::get('/report/export', [PedagangDashboardController::class, 'exportReport'])->name('report.export');
});

// Kurir routes
Route::middleware(['auth', 'kurir', 'approved'])->prefix('kurir')->name('kurir.')->group(function () {
    Route::get('/dashboard', [KurirDashboardController::class, 'index'])->name('dashboard');
    
    // Delivery management
    Route::get('/deliveries', [KurirDeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('/deliveries/history', [KurirDeliveryController::class, 'history'])->name('deliveries.history');
    Route::get('/deliveries/{order}', [KurirDeliveryController::class, 'show'])->name('deliveries.show');
    Route::post('/deliveries/{order}/pickup', [KurirDeliveryController::class, 'pickup'])->name('deliveries.pickup');
    Route::post('/deliveries/{order}/deliver', [KurirDeliveryController::class, 'deliver'])->name('deliveries.deliver');
    
    // Return management
    Route::get('/returns', [KurirReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{return}', [KurirReturnController::class, 'show'])->name('returns.show');
    Route::post('/returns/{return}/pickup', [KurirReturnController::class, 'pickup'])->name('returns.pickup');
    Route::post('/returns/{return}/deliver', [KurirReturnController::class, 'deliver'])->name('returns.deliver');
    Route::post('/returns/{return}/deliver-replacement', [KurirReturnController::class, 'deliverReplacement'])->name('returns.deliver-replacement');
});
