<?php

use App\Http\Controllers\Api\NpsController;
use App\Http\Controllers\Api\PenilaianPetugasController;
use Illuminate\Support\Facades\Route;

// ============================================
// API untuk Layar UPP (Penilaian Petugas & NPS)
// ============================================
Route::post('/penilaian-petugas/store', [PenilaianPetugasController::class, 'store']);
Route::post('/nps/store', [NpsController::class, 'store']);
