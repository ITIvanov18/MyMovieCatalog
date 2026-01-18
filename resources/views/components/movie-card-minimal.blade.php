@props(['movie'])

<div class="bg-gray-50 rounded-lg overflow-hidden hover:shadow-lg transition border border-gray-100 group">
    <a href="{{ route('movies.show', $movie->id) }}" class="block relative aspect-[2/3]">
        @if ($movie->poster)
            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 text-xs">No Poster</div>
        @endif
        
        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition duration-300"></div>
    </a>
    <div class="p-3">
        <h4 class="font-bold text-sm text-gray-800 truncate">{{ $movie->title }}</h4>
        <p class="text-xs text-gray-500">{{ $movie->year }}</p>
    </div>
</div>