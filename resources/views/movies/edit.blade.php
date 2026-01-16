<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Movie: {{ $movie->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Title</label>
                        <input type="text" name="title" value="{{ $movie->title }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Director</label>
                        <input type="text" name="director" value="{{ $movie->director }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div class="flex gap-4 mb-4">
<div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Genre</label>
                            
                            <select name="genre" class="w-full border rounded px-3 py-2 bg-white text-gray-700 focus:outline-none focus:border-indigo-500" required>
                                @php
                                    $genres = [
                                        'Action', 
                                        'Drama', 
                                        'Comedy', 
                                        'Sci-Fi', 
                                        'Horror', 
                                        'Romance', 
                                        'Documentary', 
                                        'Biography', 
                                        'Fantasy', 
                                        'Thriller', 
                                        'Anime'
                                    ];
                                @endphp

                                <option value="" disabled>Select a genre</option>
                                
                                @foreach($genres as $genreOption)
                                    <option value="{{ $genreOption }}" {{ $movie->genre == $genreOption ? 'selected' : '' }}>
                                        {{ $genreOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Year</label>
                            <input type="number" name="year" value="{{ $movie->year }}" class="w-full border rounded px-3 py-2" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full border rounded px-3 py-2" required>{{ $movie->description }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Change Poster (Optional)</label>
                        <input type="file" name="poster" class="w-full text-gray-500">
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('movies.show', $movie->id) }}" class="text-gray-600 hover:text-gray-900 font-bold py-2">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded hover:bg-indigo-700">
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>