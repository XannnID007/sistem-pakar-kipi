<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole; // Import middleware class

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {

    // Route dashboard utama yang redirect sesuai role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'pakar') {
            return redirect()->route('pakar.dashboard');
        } elseif ($role === 'pengguna') {
            return redirect()->route('dashboard.user');
        } elseif ($role === 'kepala_puskesmas') {
            return redirect()->route('kepala.dashboard');
        }
        abort(403, 'Role tidak dikenali');
    })->name('dashboard');

    // Dashboard pakar
    Route::get('/dashboard/pakar', function () {
        return view('pakar.dashboard');
    })->middleware(CheckRole::class . ':pakar')->name('pakar.dashboard');

    // Dashboard pengguna
    Route::get('/dashboard/user', function () {
        return view('user.dashboard');
    })->middleware(CheckRole::class . ':pengguna')->name('dashboard.user');

    // Dashboard kepala puskesmas
    Route::get('/dashboard/kepala', function () {
        return view('kepala.dashboard');
    })->middleware(CheckRole::class . ':kepala_puskesmas')->name('kepala.dashboard');

});

use App\Http\Controllers\DiagnosisController;

Route::middleware('auth')->group(function () {
    Route::get('/diagnosa/data', [DiagnosisController::class, 'showDataForm'])->name('diagnosa.data');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.data.store');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.storeData');
    Route::get('/diagnosa/gejala', [DiagnosisController::class, 'showGejalaForm'])->name('diagnosa.gejala');
    Route::post('/diagnosa/proses', [DiagnosisController::class, 'prosesDiagnosa'])->name('diagnosa.proses');
    Route::get('/diagnosa/ulang', [DiagnosisController::class, 'diagnosaUlang'])->name('diagnosa.ulang');
   
});
use App\Http\Controllers\PakarController;

Route::get('pakar/user', [PakarController::class, 'user'])->name('pakar.user');
Route::get('/dashboard/pakar', [PakarController::class, 'dashboard'])->name('pakar.dashboard');
Route::resource('pakar/pakar', PakarController::class)->except(['show']);
Route::get('/pakar/riwayat-diagnosa', [PakarController::class, 'riwayatDiagnosa'])->name('pakar.riwayat');
Route::get('/pakar/laporan', [PakarController::class, 'laporan'])->name('pakar.laporan');
Route::get('/pakar/laporan/cetak', [PakarController::class, 'cetakLaporan'])->name('pakar.cetak_laporan');
Route::delete('/pakar/user/{id}', [UserController::class, 'destroy'])->name('pakar.user.destroy');



use App\Http\Controllers\GejalaController;

Route::prefix('pakar')->name('pakar.')->group(function () {
    Route::resource('gejala', GejalaController::class);
});

use App\Http\Controllers\KategoriKipiController;

Route::prefix('pakar')->name('pakar.')->group(function () {
    Route::resource('kategori_kipi', KategoriKipiController::class);
});
use App\Http\Controllers\PengetahuanController;

Route::prefix('pakar')->name('pakar.')->group(function () {
    Route::get('/pengetahuan', [PengetahuanController::class, 'index'])->name('pengetahuan.index');
    Route::get('/pengetahuan/create', [PengetahuanController::class, 'create'])->name('pengetahuan.create');
    Route::post('/pengetahuan', [PengetahuanController::class, 'store'])->name('pengetahuan.store');
    Route::resource('pengetahuan', PengetahuanController::class)->except(['show']);
});
use App\Http\Controllers\RiwayatDiagnosaController;
Route::get('/riwayat-diagnosa', [RiwayatDiagnosaController::class, 'index'])->name('riwayat.index');
Route::post('/riwayat-diagnosa/simpan', [RiwayatDiagnosaController::class, 'simpan'])->name('riwayat.simpan');
Route::get('/riwayat/kipi-berat', [RiwayatDiagnosaController::class, 'kipiBerat'])->name('riwayat.kipi_berat');
Route::get('/pakar/riwayat/kipi', [RiwayatDiagnosaController::class, 'kipi'])->name('pakar.riwayat.kipi');

Route::get('/riwayat/{id}', [RiwayatDiagnosaController::class, 'show'])->name('riwayat.show');
Route::delete('/riwayat/{id}', [RiwayatDiagnosaController::class, 'destroy'])->name('riwayat.destroy');
Route::get('/riwayat/{id}/cetak', [RiwayatDiagnosaController::class, 'cetak'])->name('riwayat.cetak');
Route::get('/pakar/riwayat/kipi-berat/{id}', [RiwayatDiagnosaController::class, 'detailBerat'])->name('pakar.riwayat.berat.detail');
Route::get('/pakar/riwayat/kipi/print', [RiwayatDiagnosaController::class, 'print'])->name('pakar.riwayat.kipi.print');
Route::post('/pakar/riwayat/kirim', [RiwayatDiagnosaController::class, 'kirim'])->name('pakar.riwayat.kipi.kirim');

// Route KIPI Berat - PAKAR
Route::get('/pakar/riwayat/kipi-berat/{id}', [RiwayatDiagnosaController::class, 'detailBerat'])->name('pakar.riwayat.berat.detail');

Route::post('/pakar/kipi-berat/{id}/kirim', [RiwayatDiagnosaController::class, 'kirimKIPIBerat'])->name('pakar.riwayat.berat.kirim');

use App\Http\Controllers\KepalaController;

Route::get('/kepala/laporan-kipi', [KepalaController::class, 'laporanKIPI'])->name('kepala.laporan.kipi');
// Route untuk kepala melihat laporan
Route::middleware(['auth', CheckRole::class . ':kepala_puskesmas'])->prefix('kepala')->group(function () {
    Route::get('/laporan', [KepalaController::class, 'LaporanKiPI'])->name('kepala.laporan_kipi');
    Route::get('/laporan/{id}', [KepalaController::class, 'showLaporan'])->name('kepala.laporan.show');
    Route::delete('/kepala/laporan/{id}', [KepalaController::class, 'destroy'])->name('kepala.laporan.destroy');
    Route::get('/kepala/laporan', [KepalaController::class, 'laporanKIPI'])->name('kepala.laporan.index');
    Route::get('/kepala/laporan-berat', [KepalaController::class, 'indexBerat'])->name('kepala.laporan.berat');
    Route::delete('/kepala/laporan-berat/{id}', [KepalaController::class, 'destroyLaporanBerat'])->name('kepala.laporan.berat.destroy');

Route::delete('/kepala/laporan/delete/{id}', [KepalaController::class, 'destroy'])->name('kepala.laporan.delete');
Route::prefix('kepala/laporan')->name('kepala.laporan.')->middleware('auth')->group(function () {
    Route::get('/', [KepalaController::class, 'index'])->name('index'); // daftar laporan
    Route::get('/{id}', [KepalaController::class, 'show'])->name('show'); // lihat PDF
    Route::delete('/{id}', [KepalaController::class, 'destroy'])->name('destroy'); // hapus
    
   

});




});








