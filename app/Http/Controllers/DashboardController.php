<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // АКО Е АДМИН (Dashboard)
        if ($user->role === 'admin') {
            $movieCount = Movie::count();
            $userCount = User::count();
            $latestMovies = Movie::latest()->take(5)->get();

            return view('dashboard', compact('movieCount', 'userCount', 'latestMovies'));
        }

        // 2. АКО Е ПОТРЕБИТЕЛ (MyLibrary)
        $watchlistMovies = $user->movies()->wherePivot('type', 'watchlist')->latest('pivot_created_at')->get();
        $favoriteMovies = $user->movies()->wherePivot('type', 'favorite')->latest('pivot_created_at')->get();
        $watchedMovies = $user->movies()->wherePivot('type', 'watched')->latest('pivot_created_at')->get();

        return view('dashboard', compact('watchlistMovies', 'favoriteMovies', 'watchedMovies'));
    }
}