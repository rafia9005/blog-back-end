<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostsResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function get()
    {
        $posts = Posts::with('Author:id,name,email')->get();
        if ($posts->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "No Content"
            ], 204);
        }
        return PostsResource::collection($posts);
    }

    public function getById($id)
    {
        $posts = Posts::with('Author:id,name,email')->findOrFail($id);

        if (!$posts) {
            return response()->json([
                "status" => false,
                "message" => "Not Found"
            ], 404);
        }

        return new PostsResource($posts);
    }
    public function store(StorePostRequest $request)
    {
        $authorId = Auth::id();

        $post = new Posts();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->author = $authorId;
        $post->created_at = now();

        $post->save();

        return response()->json([
            "message" => "succes"
        ]);
    }
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Posts::findOrFail($id);

        if (!$post) {
            return response()->json([
                "status" => false,
                "message" => "Not Found"
            ], 404);
        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->updated_at = now();

        $post->save();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function delete(Request $request, $id)
    {
        $posts = Posts::findOrFail($id);

        if (!$posts) {
            return response()->json([
                "status" => false,
                "message" => "404 not found"
            ], 404);
        }

        $posts->delete();

        return response()->json([
            "status" => true,
            "message" => "success"
        ]);
    }
}
