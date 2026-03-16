<?php

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

// Dashboard route (protected)
Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// Profile routes
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth')->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});
