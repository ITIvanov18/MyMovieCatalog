<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $movie->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex flex-col md:flex-row gap-8">

                        <div class="w-full md:w-1/3 flex justify-center md:justify-start">
                            @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}"
                                alt="{{ $movie->title }}"
                                style="max-height: 500px; width: auto;"
                                class="rounded-lg shadow-lg object-contain">
                            @else
                            <div class="w-full h-80 bg-gray-200 flex items-center justify-center rounded-lg text-gray-400">
                                No Poster
                            </div>
                            @endif
                        </div>

                        <div class="w-full md:w-2/3">

                            <div class="flex justify-between items-start">
                                <div>
                                    <h1 class="text-4xl font-bold text-gray-900 leading-tight">{{ $movie->title }}</h1>

                                    <p class="text-lg text-gray-600 mt-1">Directed by: <span class="font-semibold text-gray-900">{{ $movie->director ?? 'Unknown' }}</span></p>

                                    <div class="mt-3">
                                        <span class="inline-block bg-indigo-100 text-indigo-800 text-sm font-semibold px-3 py-1 rounded-full">
                                            {{ $movie->genre }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-3">
                                    <span class="text-2xl font-bold text-gray-400 border border-gray-200 px-3 py-1 rounded-lg">
                                        {{ $movie->year }}
                                    </span>

                                    {{-- ЗОНА САМО ЗА АДМИНИСТРАТОРИ (Edit + Delete) --}}
                                    {{-- проверява дали потребителят съществува И дали е админ --}}
                                    @if(auth()->user() && auth()->user()->role === 'admin')

                                    {{-- EDIT бутон --}}
                                    <a href="{{ route('movies.edit', $movie->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition shadow">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                        Edit
                                    </a>

                                    {{-- DELETE бутон --}}
                                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this movie? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition shadow">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                    @endif

                                </div>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-bold text-gray-900 border-b border-gray-200 pb-2 mb-4">Plot Summary</h3>
                                <p class="text-gray-700 leading-relaxed text-lg">
                                    {{ $movie->description }}
                                </p>
                            </div>

                            <div class="mt-10 pt-6 border-t border-gray-100">
                                <a href="{{ url('/') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back to Catalog
                                </a>
                            </div>

                            @auth
                            @if(auth()->user()->role !== 'admin')
                            <div class="mt-auto pt-6 border-t border-gray-100 flex flex-wrap justify-end gap-3">

                                {{-- 1. WATCHLIST (Bookmark) --}}
                                @php $inWatchlist = $movie->isInList(auth()->user(), 'watchlist'); @endphp
                                <form action="{{ route('movies.list', $movie->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="watchlist">
                                    <button type="submit" title="Watchlist" class="p-3 rounded-full transition-all shadow-sm border {{ $inWatchlist ? 'bg-indigo-600 border-indigo-600 text-white' : 'bg-white border-gray-200 text-gray-500 hover:bg-gray-50 hover:border-gray-300' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $inWatchlist ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- 2. FAVORITE (Heart) --}}
                                @php $inFav = $movie->isInList(auth()->user(), 'favorite'); @endphp
                                <form action="{{ route('movies.list', $movie->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="favorite">
                                    <button type="submit" title="Add to Favorites" class="p-3 rounded-full transition-all shadow-sm border {{ $inFav ? 'bg-pink-500 border-pink-500 text-white' : 'bg-white border-gray-200 text-gray-500 hover:bg-gray-50 hover:border-gray-300' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $inFav ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- 3. WATCHED (Check) --}}
                                @php $isWatched = $movie->isInList(auth()->user(), 'watched'); @endphp
                                <form action="{{ route('movies.list', $movie->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="type" value="watched">
                                    <button type="submit" title="Mark as Watched" class="flex items-center gap-2 px-4 py-3 rounded-full font-bold text-sm transition-all shadow-sm border {{ $isWatched ? 'bg-green-600 border-green-600 text-white' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $isWatched ? 'Watched' : 'Mark Watched' }}</span>
                                    </button>
                                </form>

                            </div>
                            @endif
                            @endauth
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>