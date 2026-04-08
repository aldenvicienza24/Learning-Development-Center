<?php

use Illuminate\Support\Facades\Route;

// ✅ ROUTE ROOT → Dashboard (Halaman Awal)
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

// ✅ ROUTE PROFIL
Route::get('/profil', function () {
    return view('profil');
})->name('profil');

// ✅ ROUTE PROGRAM - NASIONAL & INTERNASIONAL
Route::get('/program1', function () {
    return view('program1');
})->name('program1');

Route::get('/program2', function () {
    return view('program2');
})->name('program2');

Route::get('/detail1', function () {
    return view('detail1');
})->name('detail1');

Route::get('/detail2', function () {
    return view('detail2');
})->name('detail2');

Route::get('/detail3', function () {
    return view('detail3');
})->name('detail3');

Route::get('/detail4', function () {
    return view('detail4');
})->name('detail4');

Route::get('/detail5', function () {
    return view('detail5');
})->name('detail5');

Route::get('/detail6', function () {
    return view('detail6');
})->name('detail6');

Route::get('/detaila', function () {
    return view('detaila');
})->name('detaila');

Route::get('/detailb', function () {
    return view('detailb');
})->name('detailb');

Route::get('/program?filter=pelatihan', function () {
    return view('/program?filter=pelatihan');
})->name('/program?filter=pelatihan');



// ✅ ROUTE DASHBOARD (Auth Required) - Halaman Utama
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';