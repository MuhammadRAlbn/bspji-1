<?php

use App\Http\Controllers\DetailInformasiController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\KalibrasiController;
use App\Http\Controllers\KonsultasiPendampinganController;
use App\Http\Controllers\LphController;
use App\Http\Controllers\LsihController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PelatihanTeknisController;
use App\Http\Controllers\PengujianController;
use App\Http\Controllers\PpidController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SertifikasiProdukController;
use App\Http\Controllers\TkdnController;
use App\Http\Controllers\UppController;
use App\Http\Controllers\ZonaIntegritasController;
use App\Http\Controllers\ZonaIntegritasDokumenController;
use App\Support\LandingPageData;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (LandingPageData $landingPageData) => view('welcome', $landingPageData->toArray()));

Route::get('/zona-integritas', [ZonaIntegritasController::class, 'index'])
    ->name('zona-integritas.index');

Route::get('/zona-integritas/dokumen/{dokumen}/download', [ZonaIntegritasDokumenController::class, 'download'])
    ->name('zona-integritas.dokumen.download');

Route::get('/sejarah-singkat', [ProfilController::class, 'index'])->defaults('activeTab', 'sejarah')->name('sejarah-singkat.index');
Route::get('/visi-misi', [ProfilController::class, 'index'])->defaults('activeTab', 'motto')->name('visi-misi.index');
Route::get('/tugas-fungsi', [ProfilController::class, 'index'])->defaults('activeTab', 'tugas')->name('tugas-fungsi.index');
Route::get('/struktur-organisasi', [ProfilController::class, 'index'])->defaults('activeTab', 'struktur')->name('struktur-organisasi.index');
Route::get('/profil-pejabat', [ProfilController::class, 'index'])->defaults('activeTab', 'profil')->name('profil-pejabat.index');
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
Route::get('/informasi-publik', [InformasiPublikController::class, 'index'])->name('informasi-publik.index');
Route::get('/informasi-publik/detail/{tipe}', [DetailInformasiController::class, 'show'])->name('detail-informasi.show');
Route::get('/berita', [NewsController::class, 'index'])->name('berita.index');
Route::get('/berita/{news:slug}', [NewsController::class, 'show'])->name('berita.show');
Route::post('/berita/{news:slug}/comments', [NewsCommentController::class, 'store'])
    ->middleware('throttle:news-comments')
    ->name('berita.comments.store');
Route::view('/hubungi-kami', 'hubungi-kami')->name('hubungi-kami.index');
