<?php

use App\Http\Controllers\KalibrasiController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\ProfilPejabatController;
use App\Http\Controllers\SejarahSingkatController;
use App\Http\Controllers\SertifikasiProdukController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\TugasFungsiController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sejarah-singkat', [SejarahSingkatController::class, 'index'])->name('sejarah-singkat.index');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('visi-misi.index');
Route::get('/tugas-fungsi', [TugasFungsiController::class, 'index'])->name('tugas-fungsi.index');
Route::get('/struktur-organisasi', [StrukturOrganisasiController::class, 'index'])->name('struktur-organisasi.index');
Route::get('/profil-pejabat', [ProfilPejabatController::class, 'index'])->name('profil-pejabat.index');
Route::get('/pengujian', [PengujianController::class, 'index'])->name('pengujian.index');
Route::get('/kalibrasi', [KalibrasiController::class, 'index'])->name('kalibrasi.index');
Route::get('/sertifikasi-produk', [SertifikasiProdukController::class, 'index'])->name('sertifikasi-produk.index');
