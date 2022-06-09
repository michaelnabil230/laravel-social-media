<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'community_id' => rand(1, 50),
            'user_id' => rand(1, 100),
            'title' => $this->faker->text(50),
            'post' => $this->faker->text(500),
        ];
    }
}
