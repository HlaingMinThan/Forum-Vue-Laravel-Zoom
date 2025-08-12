<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'slug' => fake()->slug(),
        ];
    }

    /**
     * Create the 6 specific forum tags
     */
    public function forumTags(): array
    {
        $tags = [
            [
                'name' => 'laravel',
                'slug' => 'laravel',
            ],
            [
                'name' => 'vue',
                'slug' => 'vue',
            ],
            [
                'name' => 'javascript',
                'slug' => 'javascript',
            ],
            [
                'name' => 'php',
                'slug' => 'php',
            ],
            [
                'name' => 'css',
                'slug' => 'css',
            ],
            [
                'name' => 'tailwind',
                'slug' => 'tailwind',
            ],
        ];

        return $tags[array_rand($tags)];
    }
}
