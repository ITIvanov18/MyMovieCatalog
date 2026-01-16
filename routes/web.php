<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;

// начална страница
Route::get('/', function () {
    // взема филмите от базата (най-новите най-отпред)
    $movies = Movie::latest()->get();

    // праща ги на view-то чрез compact
    return view('welcome', compact('movies'));
});

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// профил на потребителя
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// админ панел (за филмите)
// трябва задължително да си логнат И си admin
Route::middleware(['auth', AdminMiddleware::class])->group(function () { 
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
});

// маршрут за разглеждане на единичен филм
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// зареждане на Auth routes (login/register)
require __DIR__.'/auth.php';