@props(['message'])

<div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
    <p class="text-gray-500 font-medium">{{ $message }}</p>
    <a href="{{ route('welcome') }}" class="text-indigo-600 hover:underline text-sm mt-2 inline-block font-bold">Browse Catalog</a>
</div>