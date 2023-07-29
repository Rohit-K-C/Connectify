<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($postId)
    {
        $userId = auth()->user()->id;
        $like = Like::where('post_id', $postId)->where('user_id', $userId)->first();

        if (!$like) {
            $like = new Like;
            $like->post_id = $postId;
            $like->user_id = $userId;
            $like->total_likes = 1;
            $like->save();
        }

        return response()->json(['status' => 'success']);
    }

    public function unlike($postId)
    {
        $userId = auth()->user()->id;
        $like = Like::where('post_id', $postId)->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
        }

        return response()->json(['status' => 'success']);
    }

    public function checkLike($postId)
    {
        $userId = auth()->user()->id;
        $liked = Like::where('post_id', $postId)->where('user_id', $userId)->exists();

        return response()->json(['liked' => $liked]);
    }
}
