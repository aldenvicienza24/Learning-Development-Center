<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;

// ✅ ROUTE ROOT → Dashboard (Halaman Awal)
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// ✅ ROUTE PROFIL
Route::get('/profil', function () {
    return view('profil');
})->name('profil');

// ✅ ROUTE PROGRAM - NASIONAL & INTERNASIONAL
Route::get('/program1', [ProgramController::class, 'nationalPrograms'])->name('program1');

Route::get('/program2', [ProgramController::class, 'internationalPrograms'])->name('program2');

Route::get('/program/nasional', [ProgramController::class, 'nationalPrograms'])->name('program.nasional');

Route::get('/program/internasional', [ProgramController::class, 'internationalPrograms'])->name('program.internasional');

Route::get('/program?filter=pelatihan', function () {
    return view('/program?filter=pelatihan');
})->name('/program?filter=pelatihan');

Route::get('/pendaftaran', [ProgramController::class, 'registration'])->name('pendaftaran');

// ✅ ROUTE DASHBOARD (Auth Required) - Halaman Utama
Route::get('dashboard', [ProgramController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/pendaftaran/kurangi-kuota', [ProgramController::class, 'decrementQuota'])
    ->name('pendaftaran.decrement-quota');

Route::get('/fakultas/{slug}', [ProgramController::class, 'faculty'])
    ->middleware(['auth', 'verified'])
    ->name('faculty.show');

require __DIR__.'/settings.php';
