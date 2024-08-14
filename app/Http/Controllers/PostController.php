<?php

namespace App\Http\Controllers;

use App\Actions\DeletePostAction;
use App\DataTransferObjects\PostDTO;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\BlogService;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request, BlogService $blogService): View
    {
        $page = $request->input('page', 1);

        $posts = $blogService->getAllPostsWithCommentCount(
            $request->input('s'),
            ($page - 1) * 10,
            25
        );

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(int $id, PostRepository $repository)
    {
        $post = $repository->findById($id);

        dd($post);
    }

    public function delete(int $id, DeletePostAction $action)
    {
        $action->execute(new PostDTO($id));

        return back();
    }
}
