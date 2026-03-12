<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
// Registration routes
Route::get('/register', [RegistrationController::class, 'showForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');

// Login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard route (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


=======
Route::get('/admin/users', [UserManagementController::class, 'index'])
    ->name('admin.users.index');

Route::post('/admin/users/{id}/deactivate', [UserManagementController::class, 'deactivate'])
    ->name('admin.users.deactivate');
>>>>>>> feature/admin-user
