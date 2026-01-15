<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// начало
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Твоите филми
Route::middleware('auth')->group(function () {
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
});

require __DIR__.'/auth.php';