<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KendaraanController as AdminKendaraanController;
use App\Http\Controllers\Landing\GaleriController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\KendaraanController;
use App\Http\Controllers\Landing\PaketController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/paket', [PaketController::class, 'index'])->name('paket');
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan');

Route::prefix('admin')->group(function () {

    // ==== AUTH ====
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'loginAction'])->name('admin.login.action');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/kendaraan/list', [AdminKendaraanController::class, 'list'])->name('admin.kendaraan.list');

    // ==== PROTECTED ROUTE ====
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // PAGE daftar kendaraan
        Route::get('/kendaraan', [AdminKendaraanController::class, 'index'])->name('admin.kendaraan.index');
        Route::delete('/kendaraan/delete', [AdminKendaraanController::class, 'delete'])->name('admin.kendaraan.delete');
        Route::get('/kendaraan/detail/{id}', [AdminKendaraanController::class, 'detail'])
            ->name('admin.kendaraan.detail');
        Route::get('/kendaraan/create', [AdminKendaraanController::class, 'create'])
            ->name('admin.kendaraan.create');
        Route::post('/kendaraan/store', [AdminKendaraanController::class, 'store'])
            ->name('admin.kendaraan.store');

    });

});
