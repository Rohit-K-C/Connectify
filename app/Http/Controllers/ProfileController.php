<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $posts = Post::where('user_id', $user_id)->get();
        return view('profile',['posts'=>$posts]);
    }
}
