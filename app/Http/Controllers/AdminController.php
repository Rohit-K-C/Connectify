<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return view('adminDashboard');
    }

    public function manageUser(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $results = User::where('user_name', 'LIKE', "%$search%")->paginate(5);
        } else {
            $results = null;
        }
        $userDetails = User::paginate(5);
        return view('manage_user', compact('userDetails', 'results', 'search'));
    }

    public function managePost(Request $request)
    {
        $search = $request->input('search');
        $results = null;
        $users = null;
        if ($search) {
            $users = User::where('user_name', 'LIKE', "%$search%")->get();

            if ($users->count() > 0) {
                $userIds = $users->pluck('id')->toArray();
                $results = Post::whereIn('user_id', $userIds)->paginate(5);
            }
        } else {
            $results = Post::paginate(5);
        }
        return view('manage_post', compact('results', 'users', 'search'));
    }
}
