<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request, PostRepository $repository): JsonResponse
    {
        $posts = $repository
            ->getAll($request->input('s'))
            ->paginate(50);

        return new JsonResponse($posts);
    }

    public function show(int $id, PostRepository $repository)
    {
        $post = $repository->findById($id);

        return new JsonResponse($post->toArray());
    }
}
