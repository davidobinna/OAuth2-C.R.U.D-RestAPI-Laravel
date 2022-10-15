<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
     protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
         $random = rand(1,10);
          $this->model::truncate();
        return [
            //
            'name' => $this->faker->name,
            'text' => $this->faker->sentence(),
            'user_id' => intval($random)
        ];
    }
}
