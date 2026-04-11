<?php

use App\Http\Controllers\KalibrasiController;
use App\Http\Controllers\KonsultasiPendampinganController;
use App\Http\Controllers\LphController;
use App\Http\Controllers\LsihController;
use App\Http\Controllers\PelatihanTeknisController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\ProfilPejabatController;
use App\Http\Controllers\SejarahSingkatController;
use App\Http\Controllers\SertifikasiProdukController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\TkdnController;
use App\Http\Controllers\TugasFungsiController;
use App\Http\Controllers\UppController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\PpidController;
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
Route::get('/sertifikasi-produk/download/{dokumenProduk}', [SertifikasiProdukController::class, 'download'])->name('dokumen-produk.download');
Route::get('/sertifikasi-produk/informasi-publik/download/{informasi}', [SertifikasiProdukController::class, 'downloadInformasi'])->name('informasi-publik-produk.download');
Route::get('/sertifikasi-produk/hak-kewajiban/download/{hakKewajiban}', [SertifikasiProdukController::class, 'downloadHakKewajiban'])->name('hak-kewajiban-produk.download');
Route::get('/lembaga-pemeriksa-halal', [LphController::class, 'index'])->name('lph.index');
Route::get('/lsih', [LsihController::class, 'index'])->name('lsih.index');
Route::get('/verifikasi-tkdn', [TkdnController::class, 'index'])->name('tkdn.index');
Route::get('/pelatihan-teknis', [PelatihanTeknisController::class, 'index'])->name('pelatihan-teknis.index');
Route::get('/konsultasi-pendampingan', [KonsultasiPendampinganController::class, 'index'])->name('konsultasi-pendampingan.index');
Route::get('/upp', [UppController::class, 'index'])->name('upp.index');
Route::get('/ppid', [PpidController::class, 'index'])->name('ppid.index');
