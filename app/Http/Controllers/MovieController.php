<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'director' => 'required',
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
            'director' => $request->director,
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

    // показва формата за редакция
    public function edit(Movie $movie)
    {
        return view('movies.edit', compact('movie'));
    }

    // записва промените в базата
    public function update(Request $request, Movie $movie)
    {
        // ВАЛИДАЦИЯ
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'genre' => 'required|string',
            'year' => 'required|integer|min:1900|max:'.(date('Y')+5),
            'description' => 'required|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // ОБРАБОТКА НА СНИМКАТА (само ако е качена нова)
        if ($request->hasFile('poster')) {
            // трие старата снимка, за да не се пълни диска
               if ($movie->poster) {
                   Storage::disk('public')->delete($movie->poster);
               }

            // записа новата
            $path = $request->file('poster')->store('posters', 'public');
            $validatedData['poster'] = $path;
        } else {
            // ако няма нова снимка:
            unset($validatedData['poster']);
        }

        // ЗАПИС В БАЗАТА
        // използва $validatedData, за да гарантира, че влиза само позволеното
        $movie->update($validatedData);

        // ПРЕНАСОЧВАНЕ
        return redirect()->route('movies.show', $movie->id)
                         ->with('success', 'Movie updated successfully!');
    }
}