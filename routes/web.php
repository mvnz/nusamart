<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SellerOrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Registration routes
Route::get('/register', [RegistrationController::class, 'showForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Forgot & Reset Password routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.update');

// Email Verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', 'Email berhasil diverifikasi!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang ke email Anda!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Dashboard route (protected)
Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::get('/profile', [ProfileController::class, 'show'])->middleware(['auth', 'verified'])->name('profile');
Route::get('/profile/biodata', [ProfileController::class, 'showBiodata'])->middleware(['auth', 'verified'])->name('profile.biodata');
Route::put('/profile/biodata', [ProfileController::class, 'updateBiodata'])->middleware(['auth', 'verified'])->name('profile.biodata.update');
Route::get('/profile/alamat', [\App\Http\Controllers\AddressController::class, 'index'])->middleware(['auth', 'verified'])->name('profile.alamat');
Route::post('/profile/alamat', [\App\Http\Controllers\AddressController::class, 'store'])->middleware(['auth', 'verified'])->name('profile.alamat.store');
Route::put('/profile/alamat/{address}', [\App\Http\Controllers\AddressController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.alamat.update');
Route::delete('/profile/alamat/{address}', [\App\Http\Controllers\AddressController::class, 'destroy'])->middleware(['auth', 'verified'])->name('profile.alamat.destroy');
Route::post('/profile/alamat/{address}/primary', [\App\Http\Controllers\AddressController::class, 'setPrimary'])->middleware(['auth', 'verified'])->name('profile.alamat.primary');
Route::put('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->middleware(['auth', 'verified'])->name('profile.photo');
Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->middleware(['auth', 'verified'])->name('profile.photo.delete');
Route::get('/profile/password', [ProfileController::class, 'showChangePassword'])->middleware(['auth', 'verified'])->name('profile.password');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->middleware(['auth', 'verified'])->name('profile.password.update');

// Produk routes (public browsing)
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/kategori', [ProductController::class, 'categories'])->name('categories.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

// Seller Product Management routes (auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/produk-saya', [ProductController::class, 'myProducts'])->name('products.my-products');
    Route::post('/produk', [ProductController::class, 'store'])->name('products.store');
    Route::put('/produk/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/produk/{product}/simpan', [ProductController::class, 'update'])->name('products.update-post');
    Route::post('/produk/{product}/photo', [ProductController::class, 'uploadPhoto'])->name('products.upload-photo');
    Route::post('/produk/{product}/photo/hapus', [ProductController::class, 'deletePhoto'])->name('products.delete-photo-post');
    Route::delete('/produk/{product}/photo', [ProductController::class, 'deletePhoto'])->name('products.delete-photo');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/produk/{product}/hapus', [ProductController::class, 'destroy'])->name('products.destroy-post');

    // Seller Promo Management routes
    Route::get('/promo', [\App\Http\Controllers\SellerPromoController::class, 'index'])->name('seller.promos.index');
    Route::get('/promo/buat', [\App\Http\Controllers\SellerPromoController::class, 'create'])->name('seller.promos.create');
    Route::post('/promo', [\App\Http\Controllers\SellerPromoController::class, 'store'])->name('seller.promos.store');
    Route::get('/promo/{promo}', [\App\Http\Controllers\SellerPromoController::class, 'show'])->name('seller.promos.show');
    Route::get('/promo/{promo}/edit', [\App\Http\Controllers\SellerPromoController::class, 'edit'])->name('seller.promos.edit');
    Route::put('/promo/{promo}', [\App\Http\Controllers\SellerPromoController::class, 'update'])->name('seller.promos.update');
    Route::patch('/promo/{promo}/nonaktif', [\App\Http\Controllers\SellerPromoController::class, 'deactivate'])->name('seller.promos.deactivate');
    Route::patch('/promo/{promo}/aktif', [\App\Http\Controllers\SellerPromoController::class, 'activate'])->name('seller.promos.activate');
    Route::delete('/promo/{promo}', [\App\Http\Controllers\SellerPromoController::class, 'destroy'])->name('seller.promos.destroy');
});

// Keranjang routes (buyer only, auth required)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/beli-langsung/{product}', [CartController::class, 'buyNow'])->name('cart.buy-now');
    Route::patch('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/keranjang', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Order routes
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/terima', [OrderController::class, 'markReceived'])->name('orders.received');
    Route::patch('/pesanan/{order}/batalkan', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/pesanan/{order}/lacak', [OrderController::class, 'track'])->name('orders.track');

    // Wishlist routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Review routes
    Route::get('/review/produk/{product:id}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/review/produk/{product:id}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/review/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/review/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Public review display
Route::get('/produk/{product:id}/reviews', [ReviewController::class, 'show'])->name('reviews.show');
    Route::get('/penjual/pesanan', [SellerOrderController::class, 'index'])->name('seller.orders');
    Route::get('/penjual/pesanan/{order}', [SellerOrderController::class, 'show'])->name('seller.orders.show');
    Route::patch('/penjual/pesanan/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.status');


// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users');
    Route::patch('/users/{user}/toggle', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggleActive'])->name('admin.users.toggle');

    // Category management
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    Route::patch('/categories/{category}/toggle', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleActive'])->name('admin.categories.toggle');

    // Visitor stats
    Route::get('/visitors', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'visitors'])->name('admin.visitors');
    Route::get('/logins', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'logins'])->name('admin.logins');

    // Courier management
    Route::get('/couriers', [\App\Http\Controllers\Admin\CourierController::class, 'index'])->name('admin.couriers');
    Route::post('/couriers', [\App\Http\Controllers\Admin\CourierController::class, 'store'])->name('admin.couriers.store');
    Route::post('/couriers/{courier}', [\App\Http\Controllers\Admin\CourierController::class, 'update'])->name('admin.couriers.update');
    Route::delete('/couriers/{courier}', [\App\Http\Controllers\Admin\CourierController::class, 'destroy'])->name('admin.couriers.destroy');
    Route::patch('/couriers/{courier}/toggle', [\App\Http\Controllers\Admin\CourierController::class, 'toggleActive'])->name('admin.couriers.toggle');
    Route::post('/couriers/{courier}/services', [\App\Http\Controllers\Admin\CourierController::class, 'storeService'])->name('admin.couriers.services.store');
    Route::delete('/courier-services/{service}', [\App\Http\Controllers\Admin\CourierController::class, 'destroyService'])->name('admin.couriers.services.destroy');
    Route::patch('/courier-services/{service}/toggle', [\App\Http\Controllers\Admin\CourierController::class, 'toggleService'])->name('admin.couriers.services.toggle');

    // Promo monitoring & management
    Route::get('/promos', [\App\Http\Controllers\Admin\AdminPromoController::class, 'index'])->name('admin.promos');
    Route::get('/promos/{promo}', [\App\Http\Controllers\Admin\AdminPromoController::class, 'show'])->name('admin.promos.show');
    Route::patch('/promos/{promo}/nonaktif', [\App\Http\Controllers\Admin\AdminPromoController::class, 'deactivate'])->name('admin.promos.deactivate');
    Route::patch('/promos/{promo}/aktif', [\App\Http\Controllers\Admin\AdminPromoController::class, 'activate'])->name('admin.promos.activate');
    Route::delete('/promos/{promo}', [\App\Http\Controllers\Admin\AdminPromoController::class, 'destroy'])->name('admin.promos.destroy');
});

// Info pages
Route::get('/tentang', [PageController::class, 'tentang'])->name('page.tentang');

// Wilayah API routes (public, for cascading dropdowns)
Route::prefix('api/wilayah')->name('wilayah.')->group(function () {
    Route::get('/provinces', [WilayahController::class, 'provinces'])->name('provinces');
    Route::get('/regencies/{code}', [WilayahController::class, 'regencies'])->name('regencies');
    Route::get('/districts/{code}', [WilayahController::class, 'districts'])->name('districts');
    Route::get('/villages/{code}', [WilayahController::class, 'villages'])->name('villages');
});
Route::get('/kontak', [PageController::class, 'kontak'])->name('page.kontak');
Route::get('/kebijakan-privasi', [PageController::class, 'privasi'])->name('page.privasi');
Route::get('/syarat-ketentuan', [PageController::class, 'syarat'])->name('page.syarat');
Route::get('/pengembalian', [PageController::class, 'pengembalian'])->name('page.pengembalian');
Route::get('/bantuan', [PageController::class, 'bantuan'])->name('page.bantuan');
