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
                    
                    {{-- 1. АКО Е АДМИНИСТРАТОР --}}
                    @if(auth()->user()->role === 'admin')
                        <h3 class="text-2xl font-bold mb-6 text-indigo-700">Admin Control Center</h3>
                        
                        {{-- Статистика (3 карти) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-indigo-50 p-6 rounded-lg border border-indigo-100">
                                <div class="text-indigo-500 text-sm font-semibold uppercase">Total Movies</div>
                                {{-- Внимание: $movieCount идва от контролера --}}
                                <div class="text-4xl font-bold text-gray-800 mt-2">{{ $movieCount ?? 0 }}</div>
                            </div>

                            <div class="bg-green-50 p-6 rounded-lg border border-green-100">
                                <div class="text-green-600 text-sm font-semibold uppercase">Registered Users</div>
                                {{-- Внимание: $userCount идва от контролера --}}
                                <div class="text-4xl font-bold text-gray-800 mt-2">{{ $userCount ?? 0 }}</div>
                            </div>

                            <div class="flex items-center justify-center bg-gray-50 rounded-lg border border-gray-200 p-6">
                                <a href="{{ route('movies.create') }}" class="w-full text-center bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg font-bold">
                                    + Add New Movie
                                </a>
                            </div>
                        </div>

                        {{-- Последни 5 филма (Таблица) --}}
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
                                                <a href="{{ route('movies.edit', $movie->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Edit</a>
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

                    {{-- 2. АКО Е ОБИКНОВЕН ПОТРЕБИТЕЛ --}}
                    @else
                        <div class="text-center py-10">
                            <h3 class="text-2xl font-bold mb-3 text-gray-800">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                            <p class="text-gray-600 mb-8 max-w-lg mx-auto">
                                We are glad to see you again. Explore our vast catalog and find your next favorite movie to watch.
                            </p>
                            
                            <a href="{{ route('welcome') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg font-bold text-lg">
                                Browse Movies
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>