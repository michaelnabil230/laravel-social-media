<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $votes = [-1, 1];

        return [
            'post_id' => $this->faker->numberBetween(1, 200),
            'user_id' => $this->faker->numberBetween(1, 100),
            'vote' => $votes[rand(0, 1)],
        ];
    }
}
