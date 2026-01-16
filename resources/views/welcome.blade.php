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
            
            @if($movies->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($movies as $movie)
                        <a href="{{ route('movies.show', $movie->id) }}" class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col">
                            
                            <div class="relative w-full">
                                @if($movie->poster)
                                    <img src="{{ asset('storage/' . $movie->poster) }}" 
                                         alt="{{ $movie->title }}"
                                         class="movie-card-img transform group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="flex items-center justify-center bg-gray-200 text-gray-500" style="aspect-ratio: 16/9;">
                                        No Image
                                    </div>
                                @endif
                                
                                <div class="absolute bottom-2 right-2 bg-black/80 text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $movie->year }}
                                </div>
                            </div>
                            
                            <div class="p-5">
                                <h3 class="text-xl font-bold text-gray-900 truncate mb-1 group-hover:text-indigo-600">
                                    {{ $movie->title }}
                                </h3>
                                <span class="inline-block bg-indigo-50 text-indigo-700 text-xs px-2 py-1 rounded border border-indigo-100 font-semibold">
                                    {{ $movie->genre }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <h3 class="text-xl font-bold text-gray-700">Все още няма филми.</h3>
                    @auth
                        <a href="{{ route('movies.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block font-bold">
                            + Добави филм
                        </a>
                    @endauth
                </div>
            @endif

        </div>
    </div>
</x-app-layout>