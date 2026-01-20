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

                        <div class="w-full md:w-2/3 flex flex-col">

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

    {{-- СЕКЦИЯ ЗА РЕВЮТА И РЕЙТИНГ --}}
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                    💬 Reviews & Discussion
                    <span class="text-gray-400 text-sm font-normal bg-gray-100 px-2 py-1 rounded-full">Community</span>
                </h3>

                {{-- ФОРМА ЗА ПИСАНЕ (само за логнати) --}}
                @auth
                <div class="flex gap-4 mb-10 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    {{-- аватар с първата буква --}}
                    <div class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-md">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>

                    {{-- alpine.js компонент за формата и звездите --}}
                    <form action="{{ route('movies.reviews.store', $movie->id) }}" method="POST" class="w-full" x-data="{ rating: 0, hoverRating: 0 }">
                        @csrf
                        
                        {{-- текстово поле --}}
                        <textarea name="content" 
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 min-h-[100px] text-gray-700 placeholder-gray-400" 
                                  placeholder="What did you think about {{ $movie->title }}? Share your thoughts..."></textarea>
                        
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-4">
                            
                            {{-- ЗВЕЗДИЧКИ (интерактивни) --}}
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 text-sm font-medium mr-2">Your Rating:</span>
                                <div class="flex text-2xl cursor-pointer">
                                    {{-- скрит input, който ще прати данните към базата --}}
                                    <input type="hidden" name="rating" :value="rating">

                                    <template x-for="star in 5">
                                        <button type="button" 
                                                @click="rating = star" 
                                                @mouseenter="hoverRating = star" 
                                                @mouseleave="hoverRating = 0"
                                                class="transition-transform duration-150 hover:scale-110 focus:outline-none"
                                                :class="{
                                                    'text-yellow-400': hoverRating >= star || (rating >= star && hoverRating === 0),
                                                    'text-gray-300': !(hoverRating >= star || (rating >= star && hoverRating === 0))
                                                }">
                                            ★
                                        </button>
                                    </template>
                                </div>
                                
                                {{-- текст за оценка (показва се динамично) --}}
                                <span class="text-sm font-bold ml-2 text-indigo-600" x-text="rating > 0 ? rating + '/5' : ''"></span>
                                @error('rating')
                                    <p class="text-red-500 text-sm mt-1">Please select a rating (1-5 stars).</p>
                                @enderror
                            </div>

                            <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-full text-sm font-bold hover:bg-gray-800 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Post Review
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300 mb-8">
                    <p class="text-gray-500">Please <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">log in</a> to leave a review.</p>
                </div>
                @endauth

                {{-- СПИСЪК С КОМЕНТАРИ --}}
                @forelse($movie->reviews as $review)
                        <div class="relative flex gap-4 group transition hover:bg-gray-50 p-4 rounded-xl border border-transparent hover:border-gray-100">
                            {{-- аватар (първа буква от името) --}}
                            <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0 text-sm border border-indigo-100 uppercase">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-gray-900">{{ $review->user->name }}</h4>
                                    <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                
                                {{-- динамични звездички --}}
                                <div class="text-yellow-400 text-sm mb-2 flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating) 
                                            ★ 
                                        @else 
                                            <span class="text-gray-200">★</span> 
                                        @endif
                                    @endfor
                                </div>
                                
                                <p class="text-gray-600 leading-relaxed text-sm">
                                    {{ $review->content }}
                                </p>
                            </div>
                            
                            {{-- КОШЧЕ ЗА ИЗТРИВАНЕ --}}
                            {{-- показва се само ако си АВТОР или АДМИН --}}
                            @auth
                                @if(auth()->id() === $review->user_id || auth()->user()->role === 'admin')
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this review?')" class="text-gray-400 hover:text-red-600 p-2 rounded-full hover:bg-red-50 transition" title="Delete Review">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        @empty
                            {{-- ако няма никакви коментари --}}
                            <div class="text-center py-10 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                                <p class="text-gray-400 italic mb-2">No reviews yet.</p>
                                <p class="text-sm text-gray-500">Be the first to share your thoughts regarding <span class="font-bold">{{ $movie->title }}</span>!</p>
                            </div>
                        @endforelse
            </div>
        </div>
    </div>
</x-app-layout>