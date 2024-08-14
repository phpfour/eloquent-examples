<?php declare(strict_types=1);

namespace App\Actions;

use App\DataTransferObjects\PostDTO;
use App\Models\Comment;
use App\Models\Post;

final class DeletePostAction
{
    public function execute(PostDTO $postData): void
    {
        $post = Post::find($postData->id);
        $post->delete();

        $post->comments->each(function (Comment $comment) {
            $comment->delete();
        });
    }
}
