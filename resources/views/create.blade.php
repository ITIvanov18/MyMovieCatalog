<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добави нов филм') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Заглавие:</label>
                            <input type="text" name="title" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex gap-4 mb-4">
                            <div class="w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Година:</label>
                                <input type="number" name="year" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Жанр:</label>
                                <select name="genre" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                    <option>Екшън</option>
                                    <option>Драма</option>
                                    <option>Комедия</option>
                                    <option>Фантастика</option>
                                    <option>Ужаси</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Описание:</label>
                            <textarea name="description" rows="4" required class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Плакат (Снимка):</label>
                            <input type="file" name="poster" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Запази филма
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>