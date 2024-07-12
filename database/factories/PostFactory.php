<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'published']);
        $createdAt = $this->faker->dateTimeBetween('-1 month', 'now');

        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(10, true),
            'status' => $status,
            'created_at' => $createdAt,
            'published_at' => $status === 'published' ? $createdAt : null,
        ];
    }
}
