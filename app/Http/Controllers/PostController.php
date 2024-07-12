<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->select('id', 'title', 'published_at', 'status', 'user_id')
            ->with(['user'])
            ->orderBy('published_at', 'desc')
            ->paginate(50);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }
}
