<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    // показва формата за добавяне
    public function create()
    {
        // проверка за админ права
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Only admins can add movies.');
        }

        return view('movies.create');
    }

    // записва данните в базата
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Only admins can add movies.');
        }

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

    // метод за изтриване
    public function destroy(Movie $movie)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {    
            abort(403, 'Unauthorized action. Only admins can delete movies.');
        }

        // ако филмът има плакат, файлът се изтрива
        if ($movie->poster) {
            Storage::delete('public/' . $movie->poster);
        }

        // изтрива записа
        $movie->delete();

        return redirect()->route('welcome')->with('success', 'Movie deleted successfully!');
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

    public function toggleList(Request $request, Movie $movie)
    {
        /** @var \App\Models\User $user */ 
        $user = Auth::user();

        if (!$user) {
            abort(403, 'You must be logged in to save movies.');
        }
        if ($user->role === 'admin') {
            abort(403, 'Admins cannot create lists.');
        }
        
        // ако полето липсва, става 'watchlist'
        $data = $request->validate([
            'type' => 'in:watchlist,favorite,watched'
        ]);

        // ако във формата има input type="hidden", го взима. ако ли не - watchlist
        $type = $data['type'] ?? 'watchlist';

        // проверка дали филмът е в списъка НА ТОЗИ user
        $exists = $user->movies()
                       ->where('movie_id', $movie->id)
                       ->wherePivot('type', $type)
                       ->exists();

        if ($exists) {
            // маха го само от неговия списък
            $user->movies()->wherePivot('type', $type)->detach($movie->id);
        } else {
            // добавя го към неговия списък
            $user->movies()->attach($movie->id, ['type' => $type]);
        }

        return back();
    }

    public function storeReview(Request $request, Movie $movie)
    {
        // валидация
        $validated = $request->validate([
            'content' => 'required|string|min:10', // поне 10 символа
            'rating' => 'required|integer|min:1|max:5', // оценка от 1 до 5
        ]);

        // създаване на ревюто
        // Laravel автоматично попълва movie_id заради връзката
        $movie->reviews()->create([
            'user_id' => Auth::id(), // взима ID-то на логнатия потребител
            'content' => $validated['content'],
            'rating' => $validated['rating'],
        ]);

        return back()->with('success', 'Review posted successfully!');
    }
}