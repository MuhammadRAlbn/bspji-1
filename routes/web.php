<?php

use App\Http\Controllers\SejarahSingkatController;
use App\Http\Controllers\TugasFungsiController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sejarah-singkat', [SejarahSingkatController::class, 'index'])->name('sejarah-singkat.index');
Route::get('/visi-misi', [VisiMisiController::class, 'index'])->name('visi-misi.index');
Route::get('/tugas-fungsi', [TugasFungsiController::class, 'index'])->name('tugas-fungsi.index');
