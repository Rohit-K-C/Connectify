<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect('/login');
        } else {
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user->id;
            }

            // Fetch likes data
            $likesData = Like::pluck('total_likes', 'post_id')->toArray();

            // Fetch comments data and handle null values by providing a default value of 0
            $commentsData = Comment::pluck('total_comments', 'post_id')->map(fn ($value) => $value ?? 0)->toArray();

            // Fetch all posts and eagerly load the 'comments' relationship
            $posts = Post::with('comments')->get();
            // dd($posts);
            $posts->load('user.profileImage');

            return view('homepage', [
                'posts' => $posts,
                'likesData' => $likesData,
                'commentsData' => $commentsData,
                'user' => $user,
            ]);
        }
    }
}
