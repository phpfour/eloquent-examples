<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 50 users
        User::factory(50)->create()->each(function ($user) {
            // Create 100-500 posts for each user
            $posts = Post::factory(rand(100, 500))->create(['user_id' => $user->id]);

            // Create 0-100 comments for each post
            $posts->each(function ($post) use ($user) {
                $numComments = rand(0, 100);
                Comment::factory($numComments)->create([
                    'user_id' => User::inRandomOrder()->first()->id,
                    'post_id' => $post->id
                ]);
            });
        });
    }
}
