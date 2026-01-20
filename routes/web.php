<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Models\Movie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ПУБЛИЧНИ МАРШРУТИ (достъпни за всички)
|--------------------------------------------------------------------------
*/

// начална страница
Route::get('/', function () {
    $movies = Movie::with('reviews')->get();
    return view('welcome', compact('movies'));
})->name('welcome');


/*
|--------------------------------------------------------------------------
| ЗАЩИТЕНИ МАРШРУТИ (само за логнати потребители/админи)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // управление на профила
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // управление на филми - CREATE
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');

    // управление на списъка (SAVE/UNSAVE)
    Route::post('/movies/{movie}/list', [MovieController::class, 'toggleList'])->name('movies.list');
    
    // управление на филми - EDIT & UPDATE
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');

    // управление на филми - DELETE
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');

    // публикуване на ревю
    Route::post('/movies/{movie}/reviews', [MovieController::class, 'storeReview'])->name('movies.reviews.store');
    
    // изтриване на ревю (ползва Review модела директно)
    Route::delete('/reviews/{review}', [App\Http\Controllers\MovieController::class, 'destroyReview'])
        ->name('reviews.destroy');
});

// преглед на отделен филм
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

require __DIR__.'/auth.php';