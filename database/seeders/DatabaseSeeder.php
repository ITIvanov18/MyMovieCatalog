<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // взима всички съществуващи филми
        $movies = Movie::all();

        // спира, ако няма филми (за да не гърми)
        if ($movies->count() === 0) {
            $this->command->info('No movies found. Add some movies first!');
            return;
        }

        // за всеки филм създава ревюта
        foreach ($movies as $movie) {
            // създава между 1 и 3 ревюта
            // Review::factory() автоматично създава и нов random User за всяко ревю
            Review::factory(rand(1, 3))->create([
                'movie_id' => $movie->id,
            ]);
        }
    }
}