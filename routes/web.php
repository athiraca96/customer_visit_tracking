<?php

use App\Http\Controllers\Admin\CustomerVisitController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/customer-call', [CustomerVisitController::class, 'index'])->name('customer_call');
        Route::post('/customer-call/store', [CustomerVisitController::class, 'store'])->name('customer_visits.store');
    });
});
