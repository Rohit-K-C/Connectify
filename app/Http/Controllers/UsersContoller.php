<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class UsersContoller extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255',
            'contact' => 'required|digits:10',
        ]);


        $user = new User();
        $user->user_name = $validatedData['user_name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->contact = $validatedData['contact'];
        // $user->is_admin ='1';
        $user->remember_token = $request->_token;
        $user->save();
        return redirect('/login');
    }
    public function showProfile($encodedUsername)
    {
        // Decode the encoded username to get the actual username
        $username = urldecode($encodedUsername);

        // Retrieve the user data based on the provided username
        $user = User::where('user_name', $username)->first();

        if (!$user) {
            // Handle the case where the user with the given username is not found
            abort(404);
        }

        $user_id = $user->id;
        $posts = Post::where('user_id', $user_id)->get();
        if ($posts->isEmpty()) {
            // If there are no posts, pass null values to the table columns
            $posts = (object)[
                'post_id' => null,
                'post_info' => null,
                'post_image' => null,
                'user_id' => null,
                'created_at' => null,
                'updated_at' => null,
                // Add more columns here if your 'posts' table has additional fields
            ];
        }
        // Pass the user data and posts to the view and render the user profile page
        return view('userProfile', ['user' => $user, 'posts' => $posts]);
    }
}
