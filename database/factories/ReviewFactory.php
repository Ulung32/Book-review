<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id"=> User::factory(),
            "book_id" => Book::factory(),
            "rating"=> $this->faker->numberBetween(1,10),
            "review" => $this->faker->paragraph
        ];
    }
}
