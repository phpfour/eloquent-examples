<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->has('s'), function (Builder $query) use ($request) {
                return $query->keyword($request->input('s'));
            })
            ->orderBy('published_at', 'desc')
            ->paginate(50);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }
}
