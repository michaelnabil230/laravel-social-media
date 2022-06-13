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
            'community_id' => $this->faker->numberBetween(1, 50),
            'user_id' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->text(50),
            'body' => $this->faker->text(500),
        ];
    }
}
