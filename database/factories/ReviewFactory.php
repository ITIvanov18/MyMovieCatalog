<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        // списък с реалистични ревюта и оценки
        $realReviews = [
            ['text' => "Absolutely loved it! The acting was superb.", 'rating' => 5],
            ['text' => "A masterpiece! Definitely watching it again.", 'rating' => 5],
            ['text' => "Best movie I've seen this year! Highly recommend.", 'rating' => 5],
            ['text' => "The soundtrack was amazing and the visuals were stunning.", 'rating' => 5],
            
            ['text' => "Solid performance by the lead actor, but the pacing was slow.", 'rating' => 4],
            ['text' => "Fun for the whole family! Good vibes.", 'rating' => 4],
            ['text' => "Dark, gritty, and intense. Just how I like it.", 'rating' => 4],
            
            ['text' => "It was okay, but the ending was a bit disappointing.", 'rating' => 3],
            ['text' => "Not what I expected, but still entertaining enough.", 'rating' => 3],
            
            ['text' => "Great visual effects, but the story was weak.", 'rating' => 2],
            ['text' => "Honestly, I fell asleep halfway through. Boring.", 'rating' => 1],
            ['text' => "Waste of time. Don't bother.", 'rating' => 1],
            ['text' => "Can I get a refund for my time? Terrible.", 'rating' => 1],
        ];

        // избира се една случайна двойка
        $selectedReview = fake()->randomElement($realReviews);

        return [
            'user_id' => \App\Models\User::factory(),
            'movie_id' => 1, 
            'rating' => $selectedReview['rating'],
            'content' => $selectedReview['text'],
        ];
    }
}