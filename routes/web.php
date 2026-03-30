<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SejarahSingkatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sejarah-singkat', [SejarahSingkatController::class, 'index'])->name('sejarah-singkat.index');
