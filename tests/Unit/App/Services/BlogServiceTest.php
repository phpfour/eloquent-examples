<?php declare(strict_types=1);

namespace Tests\Unit\App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Services\BlogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class BlogServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_posts_can_be_retrieved()
    {
        // Arrange
        $blogService = $this->app->make(BlogService::class);

        $user = User::factory()->createOne();

        $post = Post::factory()->createOne([
            'user_id' => $user->id,
        ]);

        Comment::factory()->createOne([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => true,
        ]);

        // Act
        $posts = $blogService->getAllPosts()->get();

        // Assert
        $this->assertNotEmpty($posts);
        $this->assertEquals(1, $posts->count());
        $this->assertEquals($user->id, $posts->first()->user_id);
    }

    public function test_all_posts_will_not_return_posts_if_it_does_not_have_approved_comments()
    {
        // Arrange
        $blogService = $this->app->make(BlogService::class);

        $user = User::factory()->createOne();

        $post = Post::factory()->createOne([
            'user_id' => $user->id,
        ]);

        Comment::factory()->createOne([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => false,
        ]);

        // Act
        $posts = $blogService->getAllPosts()->get();

        // Assert
        $this->assertEmpty($posts);
        $this->assertEquals(0, $posts->count());
    }
}
