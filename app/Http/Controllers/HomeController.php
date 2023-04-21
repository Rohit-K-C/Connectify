<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect('/login');
        } else {

            $posts = Post::select('*', DB::raw('(SELECT SUM(total_likes) FROM likes WHERE post_id = posts.post_id) as total_likes'))
                ->get();

            return view('home', ['posts' => $posts]);
        }
    }
}
