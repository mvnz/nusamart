<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/users', [UserManagementController::class, 'index'])
    ->name('admin.users.index');

Route::post('/admin/users/{id}/deactivate', [UserManagementController::class, 'deactivate'])
    ->name('admin.users.deactivate');