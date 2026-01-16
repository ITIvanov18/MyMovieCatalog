<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                            <input type="text" name="title" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Director</label>
                            <input type="text" name="director" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div class="flex gap-4 mb-4">
                            <div class="w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Year:</label>
                                <input type="number" name="year" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Genre:</label>
                                <select name="genre" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                    <option>Action</option>
                                    <option>Drama</option>
                                    <option>Comedy</option>
                                    <option>Sci-Fi</option>
                                    <option>Horror</option>
                                    <option>Romance</option>
                                    <option>Documentary</option>
                                    <option>Biography</option>
                                    <option>Fantasy</option>
                                    <option>Thriller</option>
                                    <option>Anime</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" rows="4" required class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                            <div class="flex justify-end">
                                <small id="char-counter" class="text-gray-500 text-xs mt-1">Checking...</small>
                            </div>
                        </div>
                        

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Poster (Image):</label>
                            <input type="file" name="poster" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-indigo-700 transition shadow-sm">
                            Save Movie
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>