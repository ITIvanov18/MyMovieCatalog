<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- АКО Е АДМИНИСТРАТОР --}}
                    @if(auth()->user()->role === 'admin')
                        <h3 class="text-2xl font-bold mb-6 text-indigo-700">Admin Control Center</h3>
                        
                        {{-- статистика (3 карти) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                                <div class="text-indigo-500 text-sm font-semibold uppercase">Total Movies</div>
                                {{-- $movieCount идва от контролера --}}
                                <div class="text-4xl font-bold text-gray-800 mt-2">{{ $movieCount ?? 0 }}</div>
                            </div>

                            <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                                <div class="text-green-600 text-sm font-semibold uppercase">Registered Users</div>
                                {{-- $userCount идва от контролера --}}
                                <div class="text-4xl font-bold text-gray-800 mt-2">{{ $userCount ?? 0 }}</div>
                            </div>

                            <div class="flex items-center justify-center bg-gray-50 rounded-lg border border-gray-200 p-6">
                                <a href="{{ route('movies.create') }}" class="w-full text-center bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg font-bold">
                                    + Add New Movie
                                </a>
                            </div>
                        </div>

                        {{-- последни 5 филма (таблица) --}}
                        <h4 class="text-lg font-bold mb-4">Recently Added Movies</h4>
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-100 text-gray-900 uppercase font-semibold">
                                    <tr>
                                        <th class="px-4 py-3">Title</th>
                                        <th class="px-4 py-3">Year</th>
                                        <th class="px-4 py-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @if(isset($latestMovies) && $latestMovies->count() > 0)
                                        @foreach($latestMovies as $movie)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3 font-medium text-gray-900">{{ $movie->title }}</td>
                                            <td class="px-4 py-3">{{ $movie->year }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-4">
                                            {{-- EDIT --}}
                                            <a href="{{ route('movies.edit', $movie->id) }}" class="text-indigo-600 hover:text-indigo-900 transition" title="Edit Movie">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" 
                                                onsubmit="return confirm('Delete {{ $movie->title }}?');">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition pt-1" title="Delete Movie">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="px-4 py-3 text-center">No movies added yet.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    {{-- АКО Е ОБИКНОВЕН USER --}}
                    @else
                        
                        <div x-data="{ tab: 'watchlist' }">
                            
                            {{-- ЗАГЛАВИЕ И ТАБОВЕ --}}
                            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                                <h3 class="text-2xl font-bold text-gray-800">My Library</h3>
                                
                                <div class="flex bg-gray-100 p-1 rounded-lg">
                                    {{-- бутон Watchlist --}}
                                    <button @click="tab = 'watchlist'" 
                                            :class="{ 'bg-white shadow text-indigo-600': tab === 'watchlist', 'text-gray-500 hover:text-gray-700': tab !== 'watchlist' }"
                                            class="px-4 py-2 rounded-md text-sm font-bold transition-all">
                                        🔖 Watchlist
                                        <span class="ml-1 text-xs bg-gray-200 px-1.5 py-0.5 rounded-full text-gray-600">{{ $watchlistMovies->count() }}</span>
                                    </button>

                                    {{-- бутон Favorites --}}
                                    <button @click="tab = 'favorites'" 
                                            :class="{ 'bg-white shadow text-pink-600': tab === 'favorites', 'text-gray-500 hover:text-gray-700': tab !== 'favorites' }"
                                            class="px-4 py-2 rounded-md text-sm font-bold transition-all">
                                        ❤️ Favorites
                                        <span class="ml-1 text-xs bg-gray-200 px-1.5 py-0.5 rounded-full text-gray-600">{{ $favoriteMovies->count() }}</span>
                                    </button>

                                    {{-- бутон History --}}
                                    <button @click="tab = 'watched'" 
                                            :class="{ 'bg-white shadow text-green-600': tab === 'watched', 'text-gray-500 hover:text-gray-700': tab !== 'watched' }"
                                            class="px-4 py-2 rounded-md text-sm font-bold transition-all">
                                        ✅ History
                                        <span class="ml-1 text-xs bg-gray-200 px-1.5 py-0.5 rounded-full text-gray-600">{{ $watchedMovies->count() }}</span>
                                    </button>
                                </div>
                            </div>

                            {{-- СЪДЪРЖАНИЕ НА ТАБОВЕТЕ --}}
                            
                            {{-- WATCHLIST TAB --}}
                            <div x-show="tab === 'watchlist'" x-transition.opacity>
                                @if($watchlistMovies->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                        @foreach($watchlistMovies as $movie)
                                            <x-movie-card-minimal :movie="$movie" />
                                        @endforeach
                                    </div>
                                @else
                                    <x-empty-state message="Your watchlist is empty." />
                                @endif
                            </div>

                            {{-- FAVORITES TAB --}}
                            <div x-show="tab === 'favorites'" x-transition.opacity style="display: none;">
                                @if($favoriteMovies->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                        @foreach($favoriteMovies as $movie)
                                            <x-movie-card-minimal :movie="$movie" />
                                        @endforeach
                                    </div>
                                @else
                                    <x-empty-state message="No favorite movies yet." />
                                @endif
                            </div>

                            {{-- WATCHED TAB --}}
                            <div x-show="tab === 'watched'" x-transition.opacity style="display: none;">
                                @if($watchedMovies->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                        @foreach($watchedMovies as $movie)
                                            <x-movie-card-minimal :movie="$movie" />
                                        @endforeach
                                    </div>
                                @else
                                    <x-empty-state message="You haven't marked any movies as watched." />
                                @endif
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>