<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\AkomodasiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinasiController;
use App\Http\Controllers\Admin\FrontpageController;
use App\Http\Controllers\Admin\KontakResmiController;
use App\Http\Controllers\Admin\PenyediaDivingController;
use App\Http\Controllers\Admin\InformasiDaerahController;

Route::prefix('admin')->group(function () {

    // ================
    // LOGIN AREA
    // ================
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('admin.login.process');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    // ==================
    // PROTECTED AREA
    // ==================
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // ==================
        // USER MANAGEMENT (SUPER ADMIN ONLY)
        // ==================
        Route::middleware('admin.super')->group(function () {
            Route::resource('/users', UserController::class);
        });

        // ==================
        // HALAMAN UTAMA (INDEX WEB MANAGEMENT)
        // ==================
        Route::get('/web-management', function () {
            return view('admin.web.index');
        })->name('admin.web.index');

        // ==================
        // PENGATURAN FRONTPAGE
        // ==================
        Route::get('/web-management/frontpage', [FrontpageController::class, 'index'])
            ->name('admin.web.frontpage');
        Route::post('/web-management/frontpage', [FrontpageController::class, 'update'])
            ->name('admin.web.frontpage.update');

        // ==================
        // INFORMASI DAERAH (SINGLE RECORD)
        // ==================
        Route::get('/web-management/informasi-daerah', [InformasiDaerahController::class, 'edit'])
            ->name('admin.web.informasi-daerah.edit');
        Route::post('/web-management/informasi-daerah', [InformasiDaerahController::class, 'update'])
            ->name('admin.web.informasi-daerah.update');

        // ==================
        // DESTINASI
        // ==================
        Route::resource('/web-management/destinasi', DestinasiController::class, [
            'as' => 'admin.web'
        ]);
        Route::delete('/web-management/destinasi/{id}/hapus-gambar', 
            [DestinasiController::class, 'hapusGambar'])
            ->name('admin.web.destinasi.hapus-gambar');

        // ==================
        // AKOMODASI
        // ==================
        Route::resource('/web-management/akomodasi', AkomodasiController::class, [
            'as' => 'admin.web'
        ]);
        Route::delete('/web-management/akomodasi/{id}/hapus-gambar',
            [AkomodasiController::class, 'hapusGambar'])
            ->name('admin.web.akomodasi.hapus-gambar');

        // ==================
        // PENYEDIA DIVING
        // ==================
        Route::resource('/web-management/diving', PenyediaDivingController::class, [
            'as' => 'admin.web'
        ]);
        Route::delete('/web-management/diving/{id}/hapus-gambar',
            [PenyediaDivingController::class, 'hapusGambar'])
            ->name('admin.web.diving.hapus-gambar');

        // ==================
        // GALERI
        // ==================
        Route::resource('/web-management/galeri', GaleriController::class, [
            'as' => 'admin.web'
        ]);
        Route::delete('/web-management/galeri/{id}/hapus-file',
            [GaleriController::class, 'hapusFile'])
            ->name('admin.web.galeri.hapus-file');

        // ==================
        // KONTAK RESMI
        // ==================
        Route::get('/web-management/kontak', [KontakResmiController::class, 'edit'])
            ->name('admin.web.kontak.edit');
        Route::put('/web-management/kontak', [KontakResmiController::class, 'update'])
            ->name('admin.web.kontak.update');

    });

});
