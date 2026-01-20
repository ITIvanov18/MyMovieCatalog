<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('MyMovieCatalog') }}
            </h2>

            <div class="relative w-64">
                <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                
                <input type="text" 
                       id="movie-search" 
                       placeholder="Search movies..." 
                       class="w-full pl-8 pr-4 py-1 border-gray-300 rounded-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                
                <small id="search-stats" class="absolute top-full right-0 mt-1 text-xs text-gray-500 text-right w-full"></small>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- СПИСЪК С ФИЛМИ --}}
            @if($movies->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                 @foreach ($movies as $movie)
                    <div class="movie-card bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full group transform hover:-translate-y-1">
                        
                        <a href="{{ route('movies.show', $movie->id) }}" class="relative block w-full aspect-[2/3] overflow-hidden bg-gray-100">
                            @if ($movie->poster)
                                <img src="{{ asset('storage/' . $movie->poster) }}" 
                                     alt="{{ $movie->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm">No Poster</span>
                                </div>
                            @endif

                            {{-- балонче за рейтинг --}}
                            @if($movie->avg_rating)
                                <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-md text-white px-2 py-1 rounded-lg flex items-center gap-1 shadow-lg border border-white/20">
                                    <span class="text-yellow-400 text-lg leading-none">★</span>
                                    <span class="text-xs font-bold pt-0.7">{{ $movie->avg_rating }}</span>
                                </div>
                            @endif

                            {{-- годината като етикет --}}
                            <div class="absolute top-2 right-2 bg-black/60 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded-md border border-white/20">
                                {{ $movie->year }}
                            </div>
                        </a>

                        <div class="p-5 flex flex-col flex-1">
                            {{-- заглавие --}}
                            <h3 class="movie-title font-bold text-lg text-gray-900 mb-2 leading-tight">
                                <a href="{{ route('movies.show', $movie->id) }}" class="hover:text-indigo-600 transition line-clamp-2">
                                    {{ $movie->title }}
                                </a>
                            </h3>

                            <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between items-center">
                                {{-- ЛЯВО: жанр --}}
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $movie->genre }}
                                </span>

                                {{-- ДЯСНО: бутон SAVE --}}
                                @auth
                                    @if(auth()->user()->role !== 'admin')
                                    <form action="{{ route('movies.list', $movie->id) }}" method="POST">
                                        @csrf
                                        
                                        {{-- проверка дали вече е в списъка --}}
                                        @php 
                                            $isSaved = $movie->isInList(auth()->user(), 'watchlist'); 
                                        @endphp

                                        <button type="submit" class="group flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all duration-200 {{ $isSaved ? 'bg-gray-900 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                            
                                            {{-- иконка --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-active:scale-90 {{ $isSaved ? 'fill-current' : 'fill-none stroke-current stroke-2' }}" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                            </svg>

                                            {{-- текст --}}
                                            <span>{{ $isSaved ? 'Saved' : 'Save' }}</span>
                                        </button>
                                    </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"></path></svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No movies found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new movie.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>