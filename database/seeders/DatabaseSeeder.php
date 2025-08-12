<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Thread;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the 5 specific forum categories
        $categories = [
            [
                'name' => 'General Discussion',
                'description' => 'Open discussions about anything',
                'slug' => 'general-discussion',
            ],
            [
                'name' => 'Technology',
                'description' => 'Tech news and discussions',
                'slug' => 'technology',
            ],
            [
                'name' => 'Help & Support',
                'description' => 'Get help and support',
                'slug' => 'help-support',
            ],
            [
                'name' => 'Community',
                'description' => 'Community events and meetups',
                'slug' => 'community',
            ],
            [
                'name' => 'Announcements',
                'description' => 'Important announcements',
                'slug' => 'announcements',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Create the 6 specific forum tags
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

        foreach ($tags as $tagData) {
            Tag::create($tagData);
        }

        Thread::factory(10)->create();
    }
}
