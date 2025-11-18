<?php

use App\Http\Controllers\Landing\GaleriController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\KendaraanController;
use App\Http\Controllers\Landing\PaketController;
use Illuminate\Support\Facades\Route;

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/paket', [PaketController::class, 'index'])->name('paket');
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan');
