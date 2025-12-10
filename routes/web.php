<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{
    HomeController,
    InfoController,
    DestinasiController,
    CultureController as FrontCulture,
    AkomodasiController,
    DivingController,
    GaleriController,
    KontakController
};

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('front.home');

Route::get('/destinasi', [DestinasiController::class, 'index'])
    ->name('front.destinasi.index');
Route::get('/destinasi/{slug}', [DestinasiController::class, 'show'])
    ->name('front.destinasi.show');
Route::get('/akomodasi', [AkomodasiController::class, 'index'])
    ->name('front.akomodasi.index');
Route::get('/akomodasi/{slug}', [AkomodasiController::class, 'show'])
    ->name('front.akomodasi.show');
Route::get('/diving', [DivingController::class, 'index'])
    ->name('front.diving.index');
Route::get('/tentang', [InfoController::class, 'index'])
    ->name('front.info.index');
Route::get('/diving/{slug}', [DivingController::class, 'show'])
    ->name('front.diving.show');
Route::get('/budaya', [FrontCulture::class, 'index'])
    ->name('front.budaya.index');
Route::get('/budaya/{slug}', [FrontCulture::class, 'show'])
    ->name('front.budaya.show');
Route::get('/galeri', [GaleriController::class, 'index'])
    ->name('front.galeri.index');
// kalau mau detail galeri:
// Route::get('/galeri/{id}', [GaleriController::class, 'show'])->name('front.galeri.show');