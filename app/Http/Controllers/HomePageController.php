<?php

namespace App\Http\Controllers;

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

            // $posts  = Post::pluck('post_id')->toArray();
            // $likesData = Like::whereIn('post_id', $posts)->pluck('total_likes', 'post_id')->toArray();
            // dd($likesData);
            $likesData = Like::pluck('total_likes', 'post_id')->toArray();
            $posts = Post::all();
            // dd($posts,$likesData);

            return view('homepage', ['posts'=>$posts, 'likesData'=>$likesData]);

            // $posts = Post::select('*', DB::raw('(SELECT SUM(total_likes) FROM likes WHERE post_id = posts.post_id) as total_likes'))
            //     ->get();
            // // dd($posts);
            // return view('homepage', ['posts' => $posts]);
        }
    }
}
