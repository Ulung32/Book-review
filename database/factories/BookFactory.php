<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Review;
use App\Models\User;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'sumary' => $this->faker->paragraph,
            'rating' => null,  
            'review_count' => 0,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $users = User::all();

            // Shuffle users to assign reviews from different users
            $shuffledUsers = $users->shuffle();

            $reviewCount = rand(3, min($shuffledUsers->count(), 10));

            foreach ($shuffledUsers->take($reviewCount) as $user) {
                Review::factory()->create([
                    'book_id' => $book->id,
                    'user_id' => $user->id,  // Ensure that each review is created by a unique user
                ]);
            }
        
            $averageRating = $book->reviews()->avg('rating');
            $reviewCount = $book->reviews()->count();

            $book->update([
                'rating' => $averageRating,
                'review_count' => $reviewCount,
            ]);
        });
    }
}
