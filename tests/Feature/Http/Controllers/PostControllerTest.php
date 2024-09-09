<?php declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_index_page_loads_without_records()
    {
        // Arrange
        $user = User::factory()->createOne();

        // Act
        $response = $this->actingAs($user)->get(route('posts.index'));

        // Assert
        $response->assertOk();
    }

    public function test_posts_without_any_comments_are_not_displayed()
    {
        // Arrange
        $user = User::factory()->createOne();

        $post = Post::factory()->createOne([
            'user_id' => $user->id
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('posts.index'));

        // Assert
        $response->assertDontSee($post->title);
    }

    public function test_posts_with_approved_comments_are_displayed()
    {
        // Arrange
        $user = User::factory()->createOne();

        $post = Post::factory()->createOne([
            'user_id' => $user->id
        ]);

        $comment = Comment::factory()->createOne([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => true,
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('posts.index'));

        // Assert
        $response->assertSee($post->title);
    }

    public function test_posts_with_unapproved_comments_are_not_displayed()
    {
        // Arrange
        $user = User::factory()->createOne();

        $post = Post::factory()->createOne([
            'user_id' => $user->id
        ]);

        $comment = Comment::factory()->createOne([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => false,
        ]);

        // Act
        $response = $this->actingAs($user)->get(route('posts.index'));

        // Assert
        $response->assertDontSee($post->title);
    }
}
