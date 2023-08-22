<?php

// app/Http/Controllers/LikeController.php

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
        } else {
            $like->delete();
        }

        $totalLikes = Like::where('post_id', $postId)->count();
        return response()->json(['status' => 'success', 'total_likes' => $totalLikes]);
    }
}


