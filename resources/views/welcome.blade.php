<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                MyMovieCatalog
            </h2>

            @auth
                <a href="{{ route('movies.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-indigo-700 transition shadow-sm">
                    + Add New Movie
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
            <input type="text" id="movie-search" placeholder="Type to search movies..." class="w-full p-2 border rounded-lg shadow-sm">
            <small id="search-stats" class="text-gray-500"></small>
            </div>
            
            @if($movies->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                 @foreach ($movies as $movie)
            <div class="movie-card bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col h-full group">
                
                <a href="{{ route('movies.show', $movie->id) }}" class="relative block w-full aspect-[2/3] overflow-hidden">
                    @if ($movie->poster)
                        <img src="{{ asset('storage/' . $movie->poster) }}" 
                             alt="{{ $movie->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                            No Poster
                        </div>
                    @endif

                    <div class="absolute top-2 right-2 bg-black/70 text-white text-xs font-bold px-2 py-1 rounded">
                        {{ $movie->year }}
                    </div>
                </a>

                <div class="p-4 flex flex-col flex-1">
                    <h3 class="movie-title font-bold text-lg text-gray-900 mb-1 leading-tight truncate">
                        <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-indigo-600 transition">
                            {{ $movie->title }}
                        </a>
                    </h3>

                    <div class="mt-auto flex justify-between items-center">
                        <span class="inline-block bg-indigo-50 text-indigo-700 text-xs font-semibold px-2 py-1 rounded-md border border-indigo-100">
                            {{ $movie->genre }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
            @else
                <div class="text-center py-20">
                    <h3 class="text-xl font-bold text-gray-700">No movies yet.</h3>
                    @auth
                        <a href="{{ route('movies.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block font-bold">
                            + Add your first movie
                        </a>
                    @endauth
                </div>
            @endif

        </div>
    </div>
</x-app-layout>