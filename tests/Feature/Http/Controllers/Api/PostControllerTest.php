<?php declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_api_returns_posts_in_correct_format()
    {
        $user = User::factory()->createOne();

        $post = Post::factory()->createOne([
            'user_id' => $user->id
        ]);

        $comment = Comment::factory()->createOne([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'is_approved' => true,
        ]);

        $response = $this->getJson(route('api.posts.index'));

        $response->assertOk();

        $response->assertJson([
            'data' => [
                [
                    'title' => $post->title,
                ]
            ]
        ]);

        $response->assertJsonPath('total', 1);
        $response->assertJsonPath('links.0.label', "&laquo; Previous");
    }
}
