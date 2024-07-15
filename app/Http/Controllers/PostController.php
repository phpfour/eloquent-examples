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
            ->with(['user'])
            ->whereHas('comments', function (Builder $query) {
                $query->where('is_approved', true);
            })
            ->when($request->has('s'), function (Builder $query) use ($request) {
                return $query->keyword($request->input('s'));
            })
            ->withCount(['comments' => function (Builder $query) {
                $query->where('is_approved', true);
            }])
            ->orderBy('published_at', 'desc')
            ->paginate(50);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }
}
