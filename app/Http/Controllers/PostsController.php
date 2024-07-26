<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    public function index()
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

    public function show($id)
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
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }

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
}
