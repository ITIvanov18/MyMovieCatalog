<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // статистика
        $movieCount = Movie::count();
        $userCount = User::count();
        
        // последните 5 добавени филма (за админ панела)
        $latestMovies = Movie::latest()->take(5)->get();

        return view('dashboard', compact('movieCount', 'userCount', 'latestMovies'));
    }
}