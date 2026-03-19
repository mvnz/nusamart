<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;

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

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});
