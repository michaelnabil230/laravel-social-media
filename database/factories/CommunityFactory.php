<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(30),
            'user_id' => rand(1, 100),
            'description' => $this->faker->text(200),
        ];
    }
}
