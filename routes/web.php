<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryKendaraanController;
use App\Http\Controllers\Admin\KendaraanController as AdminKendaraanController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\WisataController as AdminWisataController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\OpenTripController;
use App\Http\Controllers\Admin\OpenTripDestinationController;
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController; 
use App\Http\Controllers\Admin\OpenTripScheduleController;
use App\Http\Controllers\Landing\GaleriController;
use App\Http\Controllers\Landing\HomeController;
use App\Http\Controllers\Landing\KendaraanController;
use App\Http\Controllers\Landing\PaketController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Landing\AboutController;
use App\Http\Controllers\Landing\TestimoniController;
use Illuminate\Support\Facades\Route;

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/paket', [PaketController::class, 'index'])->name('paket');

Route::get('/search', [HomeController::class, 'search'])->name('search');

// Open Trip Detail
Route::get('/paket/opentrip/{id}', [PaketController::class, 'detailOpenTrip'])->name('opentrip.detail');
Route::get('/paket/wisata/user/{id}', [PaketController::class, 'detailWisata'])->name('wisata.user.detail');

Route::get('/', [HomeController::class, 'index'])->name('/');

//kendaraan-landing
Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan');
Route::get('/kendaraan/pesan/{id}', [KendaraanController::class, 'pesan'])->name('pesan.kendaraan');
Route::post('/kendaraan/whatsapp', [KendaraanController::class, 'kirimWhatsApp'])->name('kendaraan.whatsapp');

Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni');
Route::get('/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
Route::post('/testimoni/store', [TestimoniController::class, 'store'])
    ->name('testimoni.store');

Route::prefix('admin')->group(function () {

    Route::resource('kontak', AdminContactController::class)->except(['create', 'edit', 'show']);

    // ==== AUTH ====
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'loginAction'])->name('admin.login.action');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('/kendaraan/list', [AdminKendaraanController::class, 'list'])->name('admin.kendaraan.list');

    // ==== PROTECTED ROUTE ====
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // PAGE daftar kendaraan
        Route::prefix('kendaraan')->name('admin.kendaraan.')->group(function () {
            Route::get('/', [AdminKendaraanController::class, 'index'])
                ->name('index');
            Route::get('/create', [AdminKendaraanController::class, 'create'])
                ->name('create');

            Route::post('/store', [AdminKendaraanController::class, 'store'])
                ->name('store');
            Route::get('/edit/{id}', [AdminKendaraanController::class, 'edit'])
                ->name('edit');
            Route::post('/update/{id}', [AdminKendaraanController::class, 'update'])
                ->name('update');
            Route::get('/detail/{id}', [AdminKendaraanController::class, 'detail'])
                ->name('detail');
            Route::delete('/delete/{id}', [AdminKendaraanController::class, 'delete'])
                ->name('delete');
            Route::post('/update-tampilkan-harga', [AdminKendaraanController::class, 'updateTampilkanHarga'])
                ->name('update-tampilkan-harga');
        });


        // Kategori Kendaraan
        Route::prefix('kategori-kendaraan')->name('kategori-kendaraan.')->group(function () {

            Route::get('/', [CategoryKendaraanController::class, 'index'])->name('index');
            Route::get('/list', [CategoryKendaraanController::class, 'list'])->name('list');

            Route::get('/create', [CategoryKendaraanController::class, 'create'])->name('create');
            Route::post('/store', [CategoryKendaraanController::class, 'store'])->name('store');

            Route::get('/kategori-kendaraan/show', [CategoryKendaraanController::class, 'show'])->name('show');
            Route::put('/kategori-kendaraan/update', [CategoryKendaraanController::class, 'update'])->name('update');

            Route::delete('/delete', [CategoryKendaraanController::class, 'delete'])->name('delete');
        });

        Route::prefix('testimoni')->name('testimoni.')->group(function () {
            Route::get('/', [AdminTestimoniController::class, 'index'])->name('index');
            Route::post('/reply/{id_testimoni}', [AdminTestimoniController::class, 'reply'])->name('reply');
            Route::delete('/delete/{id_testimoni}', [AdminTestimoniController::class, 'destroy'])->name('delete');
        });

        //galeri admin
        Route::prefix('galeri')->name('galeri.')->group(function () {

            Route::get('/', [AdminGaleriController::class, 'index'])->name('index');
            Route::get('/list', [AdminGaleriController::class, 'list'])->name('list');
            Route::post('/store', [AdminGaleriController::class, 'store'])->name('store');

            // ✅ HARUS PAKAI PARAMETER ID
            Route::get('/edit/{id}', [AdminGaleriController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [AdminGaleriController::class, 'update'])->name('update');

            Route::delete('/delete', [AdminGaleriController::class, 'delete'])->name('delete');
        });

        Route::prefix('wisata')->name('wisata.')->group(function () {
            Route::get('/', [AdminWisataController::class, 'index'])->name('index');
            Route::get('/list', [AdminWisataController::class, 'list'])->name('list');
            Route::get('/create', [AdminWisataController::class, 'create'])->name('create');
            Route::post('/store', [AdminWisataController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [AdminWisataController::class, 'detail'])->name('detail'); // FIXED
            Route::get('/edit/{id}', [AdminWisataController::class, 'edit'])->name('edit'); // tambahkan edit route
            Route::post('/update/{id}', [AdminWisataController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [AdminWisataController::class, 'delete'])->name('delete');
        });

        //open trip admin
        Route::prefix('trip')->name('trip.')->group(function () {

            Route::get('/', [OpenTripController::class, 'index'])->name('index');
            Route::get('/list', [OpenTripController::class, 'list'])->name('list');
            Route::get('/create', [OpenTripController::class, 'create'])->name('create');
            Route::post('/store', [OpenTripController::class, 'store'])->name('store');
            
            Route::get('/{id}/edit', [OpenTripController::class, 'edit'])->name('edit');
            Route::put('/{id}', [OpenTripController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [OpenTripController::class, 'destroy'])->name('destroy');
            Route::get('/detail/{id}', [OpenTripController::class, 'detail'])->name('detail');

            // Destinasi
            Route::post('/destinasi/store', [OpenTripDestinationController::class, 'store'])
                ->name('destinasi.store');
            Route::delete('/destinasi/delete/{id}', [OpenTripDestinationController::class, 'delete'])
                ->name('destinasi.delete');

            // Jadwal
            Route::post('/jadwal/store', [OpenTripScheduleController::class, 'store'])
                ->name('jadwal.store');
            Route::delete('/jadwal/delete/{id}', [OpenTripScheduleController::class, 'delete'])
                ->name('jadwal.delete');

            // ITINERARY
            Route::post('/itinerary/store', [OpenTripController::class, 'storeItinerary'])->name('itinerary.store');
            Route::delete('/itinerary/delete/{id}', [OpenTripController::class, 'deleteItinerary'])->name('itinerary.delete');

            // ITINERARY ITEM
            Route::post('/itinerary-item/store', [OpenTripController::class, 'storeItineraryItem'])->name('itinerary.item.store');
            Route::delete('/itinerary-item/delete/{id}', [OpenTripController::class, 'deleteItineraryItem'])->name('itinerary.item.delete');

        });

        Route::middleware(['superadmin'])->group(function () {
            Route::get('/admin/admins', [AdminController::class, 'index'])->name('admin.index');
            Route::post('/admin/admins', [AdminController::class, 'store'])->name('admin.store');
            Route::get('/admin/admins/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
            Route::put('/admin/admins/{id}', [AdminController::class, 'update'])->name('admin.update');
            Route::delete('/admin/admins/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        });

        // Halaman Profil
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');

        // Update Profil (nama, email, avatar)
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');

        // Page Ubah Password
        Route::get('/profile/password', [ProfileController::class, 'passwordPage'])->name('admin.profile.password');

        // Proses Ubah Password
        Route::post('/profile/password/update', [ProfileController::class, 'updatePassword'])->name('admin.profile.password.update');

    });

});
