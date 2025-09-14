<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\PakarController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\KategoriKipiController;
use App\Http\Controllers\PengetahuanController;
use App\Http\Controllers\RiwayatDiagnosaController;
use App\Http\Controllers\KepalaController;

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
    Route::get('/dashboard/pakar', [PakarController::class, 'dashboard'])->middleware(CheckRole::class . ':pakar')->name('pakar.dashboard');

    // Dashboard pengguna
    Route::get('/dashboard/user', function () {
        return view('user.dashboard');
    })->middleware(CheckRole::class . ':pengguna')->name('dashboard.user');

    // Dashboard kepala puskesmas
    Route::get('/dashboard/kepala', function () {
        return view('kepala.dashboard');
    })->middleware(CheckRole::class . ':kepala_puskesmas')->name('kepala.dashboard');
});

// Routes untuk Diagnosa (pengguna)
Route::middleware('auth')->group(function () {
    Route::get('/diagnosa/data', [DiagnosisController::class, 'showDataForm'])->name('diagnosa.data');
    Route::post('/diagnosa/data', [DiagnosisController::class, 'storeData'])->name('diagnosa.storeData');

    Route::get('/diagnosa/gejala', [DiagnosisController::class, 'showGejalaForm'])->name('diagnosa.gejala');
    Route::post('/diagnosa/proses', [DiagnosisController::class, 'prosesDiagnosa'])->name('diagnosa.proses');

    Route::get('/diagnosa/ulang', [DiagnosisController::class, 'diagnosaUlang'])->name('diagnosa.ulang');
    Route::post('/diagnosa/reset', [DiagnosisController::class, 'resetSession'])->name('diagnosa.reset');
});

// Routes untuk Pakar
Route::middleware(['auth', CheckRole::class . ':pakar'])->prefix('pakar')->name('pakar.')->group(function () {
    // Dashboard pakar sudah ada di atas

    // Manajemen User
    Route::get('/user', [PakarController::class, 'user'])->name('user');
    Route::delete('/user/{id}', [PakarController::class, 'destroy'])->name('user.destroy');

    // Manajemen Pakar
    Route::get('/pakar', [PakarController::class, 'index'])->name('index');
    Route::get('/pakar/create', [PakarController::class, 'create'])->name('create');
    Route::post('/pakar', [PakarController::class, 'store'])->name('store');
    Route::get('/pakar/{id}/edit', [PakarController::class, 'edit'])->name('edit');
    Route::put('/pakar/{id}', [PakarController::class, 'update'])->name('update');
    Route::delete('/pakar/{id}', [PakarController::class, 'destroy'])->name('destroy');

    // Gejala
    Route::resource('gejala', GejalaController::class);

    // Kategori KIPI
    Route::resource('kategori_kipi', KategoriKipiController::class);

    // Pengetahuan
    Route::resource('pengetahuan', PengetahuanController::class)->except(['show']);

    // Riwayat dan Laporan
    Route::get('/riwayat-diagnosa', [PakarController::class, 'riwayatDiagnosa'])->name('riwayat');
    Route::get('/laporan', [PakarController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/cetak', [PakarController::class, 'cetakLaporan'])->name('cetak_laporan');
    Route::get('/riwayat/kipi', [RiwayatDiagnosaController::class, 'kipi'])->name('riwayat.kipi');
    Route::get('/riwayat/kipi/print', [RiwayatDiagnosaController::class, 'print'])->name('riwayat.kipi.print');
    Route::post('/riwayat/kirim', [RiwayatDiagnosaController::class, 'kirim'])->name('riwayat.kipi.kirim');
    Route::get('/riwayat/kipi-berat', [RiwayatDiagnosaController::class, 'kipiBerat'])->name('riwayat.kipi_berat');
    Route::get('/riwayat/kipi-berat/{id}', [RiwayatDiagnosaController::class, 'detailBerat'])->name('riwayat.berat.detail');
    Route::post('/kipi-berat/{id}/kirim', [RiwayatDiagnosaController::class, 'kirimKIPIBerat'])->name('riwayat.berat.kirim');
});

// Routes untuk Riwayat Diagnosa (pengguna)
Route::middleware('auth')->group(function () {
    Route::get('/riwayat-diagnosa', [RiwayatDiagnosaController::class, 'index'])->name('riwayat.index');
    Route::post('/riwayat-diagnosa/simpan', [RiwayatDiagnosaController::class, 'simpan'])->name('riwayat.simpan');
    Route::get('/riwayat/{id}', [RiwayatDiagnosaController::class, 'show'])->name('riwayat.show');
    Route::delete('/riwayat/{id}', [RiwayatDiagnosaController::class, 'destroy'])->name('riwayat.destroy');
    Route::get('/riwayat/{id}/cetak', [RiwayatDiagnosaController::class, 'cetak'])->name('riwayat.cetak');
    Route::get('/riwayat/kipi-berat', [RiwayatDiagnosaController::class, 'kipiBerat'])->name('riwayat.kipi_berat');
});

// Routes untuk Kepala Puskesmas
Route::middleware(['auth', CheckRole::class . ':kepala_puskesmas'])->prefix('kepala')->name('kepala.')->group(function () {
    // Dashboard kepala sudah ada di atas

    Route::get('/laporan', [KepalaController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [KepalaController::class, 'show'])->name('laporan.show');
    Route::delete('/laporan/{id}', [KepalaController::class, 'destroy'])->name('laporan.destroy');

    Route::get('/laporan-berat', [KepalaController::class, 'indexBerat'])->name('laporan.berat');
    Route::delete('/laporan-berat/{id}', [KepalaController::class, 'destroyLaporanBerat'])->name('laporan.berat.destroy');

    Route::get('/statistik', [KepalaController::class, 'statistik'])->name('statistik');
});
