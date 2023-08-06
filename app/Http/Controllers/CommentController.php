<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        $userId = auth()->user()->id;
        $postId = $request->input('post_id');
        $comment = new Comment();
        $comment->post_id = $postId;
        $comment->user_id = $userId;
        $comment->total_comments = 1;
        $comment->comments = $request->input('comment');
        $comment->save();

        $totalComments = Comment::where('post_id', $postId)->count();

        return Redirect::back()->with('success', 'Comment submitted successfully!');    }
}
