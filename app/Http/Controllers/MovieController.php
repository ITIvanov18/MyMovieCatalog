<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // показва формата за добавяне
    public function create()
    {
        return view('movies.create');
    }

    // записва данните в базата
    public function store(Request $request)
    {
        // валидация (за да не се чупи, ако полето е празно)
        $validated = $request->validate([
            'title' => 'required|max:255',
            'year' => 'required|integer',
            'genre' => 'required',
            'description' => 'required',
            'poster' => 'image|mimes:jpeg,png,jpg|max:5120', // снимки до 5MB
        ]);

        // качване на снимката (ако има такава)
        $path = null;
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
        }

        // създаване на записа в базата
        Movie::create([
            'title' => $request->title,
            'year' => $request->year,
            'genre' => $request->genre,
            'description' => $request->description,
            'poster' => $path,
            'rating' => 0, // начален рейтинг
        ]);

        return redirect('/dashboard')->with('success', 'Movie added successfully!');
    }

    // показва детайли за конкретен филм
    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }
}