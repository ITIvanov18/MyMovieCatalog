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

                                    @auth
                                        <a href="{{ route('movies.edit', $movie->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            Edit
                                        </a>
                                    @endauth
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
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                    Back to Catalog
                                </a>
                            </div>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>