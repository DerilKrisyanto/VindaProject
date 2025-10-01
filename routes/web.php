<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Pegawai;
use App\Models\MasterBrand;
use App\Http\Controllers\TargetBrandController;
use App\Http\Controllers\DaftarTargetPromotorController;
use App\Http\Controllers\TargetTimPromotorController;
use App\Http\Controllers\TargetPromotorController;
use App\Http\Controllers\JadwalKerjaController;
use App\Http\Controllers\MasterDataController;
use Illuminate\Support\Facades\Auth;

// ==================== AUTH ROUTES ====================

Route::get('/', function () {
    if (session()->has('pegawai')) {
        return redirect()->route('home');
    }
    return view('auth.Login');
})->name('Login');

// Login form
Route::get('/Login', function () {
    return view('auth.Login');
})->name('Login.form');


// Login & Register action
Route::post('/Login', [LoginController::class, 'Login'])->name('Login');

Route::get('/Register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/Register', [RegisterController::class, 'TambahUserBaru'])->name('TambahUserBaru');


// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==================== PROTECTED ROUTES ====================

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('components.home', ['title' => 'Vinda']);
    })->name('home');

    // Route::get('/targetbrand', function () {
    //     return view('components.targetbrand', ['title' => 'Target Promotor']);
    // });

    Route::get('/contact', function () {
        return view('components.contact', ['title' => 'Contact']);
    });

    Route::get('/get-pegawais-by-brand/{brandId}', [TargetBrandController::class, 'getPegawaisByBrand']);

    // ==================== TARGET BRAND ====================
    Route::get('/from-targetbrand', [TargetBrandController::class, 'getFormInputTargetBrand'])->name('getFormInputTargetBrand');
    Route::post('/save-targetbrand-baru', [TargetBrandController::class, 'SaveTargetBrand'])->name('SaveTargetBrand');
    Route::get('/targetbrand', [TargetBrandController::class, 'getDaftarTargetBrand'])->name('getDaftarTargetBrand');
    Route::get('/targetbrand/export', [TargetBrandController::class, 'export'])->name('targetbrand.export');
    Route::get('/targetbrand/{id}/edit', [TargetBrandController::class, 'edit'])->name('targetbrand.edit');
    Route::delete('/targetbrand/{id}', [TargetBrandController::class, 'hapus'])->name('targetbrand.hapus');
    Route::put('/targetbrand/{id}', [TargetBrandController::class, 'update'])->name('targetbrand.update');

    // ==================== INPUT JADWAL KERJA ====================
    Route::get('/get-jadwal-kerja', [JadwalKerjaController::class, 'getJadwalKerja']);
    Route::get('/export-jadwal', [JadwalKerjaController::class, 'exportExcel']);
    Route::get('/input-jadwal-kerja', [JadwalKerjaController::class, 'InputJadwalKerja'])->name('Form.InputJadwalKerja');
    Route::get('/jadwal-kerja/{id}', [JadwalKerjaController::class, 'show'])->name('jadwalkerja.show');
    Route::post('/jadwal-kerja', [JadwalKerjaController::class, 'store'])->name('jadwalkerja.store');
    Route::put('/jadwal-kerja/{id}', [JadwalKerjaController::class, 'update'])->name('jadwalkerja.update');
    Route::delete('/jadwal-kerja/{id}', [JadwalKerjaController::class, 'destroy'])->name('jadwalkerja.destroy');
    Route::get('/get-toko-detail/{id}', [JadwalKerjaController::class, 'getTokoDetail'])->name('getTokoDetail');

    // ==================== EDIT JADWAL KERJA ====================
    Route::get('/edit-jadwal-kerja', [JadwalKerjaController::class, 'EditJadwalKerja'])->name('Form.EditJadwalKerja');
    Route::get('/get-spg-by-tanggal/{tanggal}', [JadwalKerjaController::class, 'getSPGbyTanggal']);
    Route::post('/get-toko-shift', [JadwalKerjaController::class, 'getTokoShift']);
    Route::post('/update-jadwal', [JadwalKerjaController::class, 'updateJadwal'])->name('jadwalkerja.store');

    // ==================== INPUT SHIFT KERJA ====================
    Route::get('/get-data-shift', [MasterDataController::class, 'getDataShift']);
    Route::post('/save-data-shift', [MasterDataController::class, 'SaveDataShift'])->name('SaveDataShift');
    Route::delete('/datashift/{id}', [MasterDataController::class, 'HapusDataShift'])->name('HapusDataShift');


    // ==================== DATA TOKO ====================
    Route::get('/get-data-toko', [MasterDataController::class, 'getDataToko']);
    Route::post('/save-data-toko', [MasterDataController::class, 'SaveDataToko'])->name('SaveDataToko');
    Route::delete('/datatoko/{id}', [MasterDataController::class, 'HapusDataToko'])->name('HapusDataToko');

    // ==================== DAFTAR TARGET PROMOTOR ====================
    Route::get('/daftartargetpromotor', [DaftarTargetPromotorController::class, 'getTargetMasterPromotor'])->name('getTargetMasterPromotor');
    Route::post('/save-daftar-targetpromotor-baru', [DaftarTargetPromotorController::class, 'SaveDaftarTargetPromotor'])->name('SaveDaftarTargetPromotor');
    Route::delete('/daftartargetpromotor/{id}', [DaftarTargetPromotorController::class, 'HapusDaftarTargetPromotor'])->name('HapusDaftarTargetPromotor');

    // ==================== TARGET TIM PROMOTOR ====================
    Route::get('/targettimpromotor', [TargetTimPromotorController::class, 'getDaftarTargetTimPromotor'])->name('getDaftarTargetTimPromotor');
    // Route::get('/-target-tim-promotor', [TargetTimPromotorController::class, 'create'])->name('targettim.create');
    Route::post('/input-target-tim-promotor', [TargetTimPromotorController::class, 'SaveTargetTim'])->name('SaveTargetTim');
    Route::get('/targettimpromotor-download', [TargetTimPromotorController::class, 'getDownloadTargetTimPromotor'])->name('getDownloadTargetTimPromotor');
    Route::get('/form-target-tim-promotor', [TargetTimPromotorController::class, 'getInputTargetTimPromotor'])->name('getInputTargetTimPromotor');
    Route::post('/hapus-target-tim-promotor/{id}', [TargetTimPromotorController::class, 'destroy'])->name('targettim.destroy');

    Route::get('/targettimpromotor/edit/{id}', [TargetTimPromotorController::class, 'editTargetTimPromotor'])->name('editTargetTimPromotor');
    Route::post('/targettimpromotor/update/{id}', [TargetTimPromotorController::class, 'updateTargetTimPromotor'])->name('updateTargetTimPromotor');
    Route::delete('/targettimpromotor/hapus/{id}', [TargetTimPromotorController::class, 'hapusTargetTimPromotor'])->name('hapusTargetTimPromotor');

    // ==================== TARGET PROMOTOR ====================
    Route::get('/targetpromotor', [TargetPromotorController::class, 'getTargetPromotor'])->name('getTargetPromotor');

    // ✅ Hapus route ini (salah arah):
    // Route::get('/form/input-targetpromotor', [TargetPromotorController::class, 'saveTargetPromotor'])->name('saveTargetPromotor');

    // ✅ Pertahankan dan pastikan hanya ini yang digunakan untuk GET form input
    Route::get('/form/input-targetpromotor', [TargetPromotorController::class, 'getFormInputTargetPromotor'])->name('getFormInputTargetPromotor');

    // ✅ Route untuk menyimpan input
    Route::post('/form/input-targetpromotor', [TargetPromotorController::class, 'saveInputTargetPromotor'])->name('saveInputTargetPromotor');

    Route::post('/form/edit-targetpromotor', [TargetPromotorController::class, 'editTargetPromotor'])->name('editTargetPromotor');
    Route::delete('/hapus-targetpromotor/{id}', [TargetPromotorController::class, 'hapusTargetPromotor'])->name('hapusTargetPromotor');

    // ==================== PROFILE dan SETTING ====================
    Route::get('/profile/edit', [RegisterController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [RegisterController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/settings', [RegisterController::class, 'showSettingsForm'])->name('settings.form');
    Route::put('/settings', [RegisterController::class, 'updateUsernamePassword'])->name('settings.update');


});

