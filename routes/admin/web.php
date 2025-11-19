<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->group(function () {

    // LOGIN
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('admin.login.process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // PROTECTED AREA
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // hanya super admin
        Route::middleware('admin.super')->group(function () {
            Route::resource('/users', UserController::class);
        });

        Route::get('/web-management', function () {
            return view('admin.web.index');
        })->name('admin.web.index');


    });
});
