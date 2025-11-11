<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Emergency Logout
Route::get('/emergency-logout', function () {
    return view('emergency-logout');
})->name('emergency.logout');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Customer Routes
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/order/create', [CustomerController::class, 'createOrder'])->name('order.create');
        Route::post('/order', [CustomerController::class, 'storeOrder'])->name('order.store');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::post('/order/{order}/confirm', [CustomerController::class, 'confirmOrder'])->name('order.confirm');
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
        Route::post('/order/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('order.status');
        Route::get('/history', [AdminController::class, 'history'])->name('history');
        Route::get('/report/print', [AdminController::class, 'printReport'])->name('report.print');
        Route::get('/report/excel', [AdminController::class, 'exportExcel'])->name('report.excel');

        // User Management
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        Route::post('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    });
});

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});
