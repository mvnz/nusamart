<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\WilayahController;

Route::get('/', function () {
    return redirect()->route('login');
});

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
Route::put('/profile', [ProfileController::class, 'update'])->middleware(['auth', 'verified'])->name('profile.update');
Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->middleware(['auth', 'verified'])->name('profile.photo');
Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->middleware(['auth', 'verified'])->name('profile.photo.delete');
Route::get('/profile/password', [ProfileController::class, 'showChangePassword'])->middleware(['auth', 'verified'])->name('profile.password');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->middleware(['auth', 'verified'])->name('profile.password.update');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users');
    Route::patch('/users/{user}/toggle', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggleActive'])->name('admin.users.toggle');
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
