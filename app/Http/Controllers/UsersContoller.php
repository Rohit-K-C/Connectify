<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255',
            'contact' => 'required|digits:10',
            '_token' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/createUser')
                ->withErrors($validator)
                ->withInput();
        }
        $user = new User();
        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->contact = $request->input('contact');
        $user->remember_token = $request->input('_token');
        $user->save();
        return redirect('/login');
    }

    public function showProfile($encodedUsername)
    {

        $username = urldecode($encodedUsername);

        $user = User::where('user_name', $username)->first();

        if (!$user) {
            abort(404);
        }
        $user_id = $user->id;
        $likesData = Like::pluck('total_likes', 'post_id')->toArray();
        $posts = Post::where('user_id', $user_id)->get();
        $user = User::with(['profileImage', 'followers', 'followedUsers'])->find($user_id);

        $totalFollowers = $user->followers()->count();
        $totalFollowing = $user->followedUsers()->count();
        $user = User::with(['profileImage', 'followers', 'followedUsers'])->find($user_id);
        $check = Follow::where('follower_id', Auth::user()->id)->where('followed_id', $user_id)->first();
        return view('profile', [
            'posts' => $posts,
            'likesData' => $likesData,
            'user' => $user,
            'totalFollowers' => $totalFollowers,
            'totalFollowing' => $totalFollowing,
            'check' => $check,
        ]);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $user->contact = $request->input('contact');
        $user->is_admin = $request->input('is_admin');
        $user->save();
        return redirect()->route('manage-user')->with('success', 'User data updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('manage-user')->with('success', 'User deleted successfully!');
    }

    public function fuCheck(Request $request)
    {
        $authId = Auth::user()->id;
        $uid = $request->input('otherUser');
        $check = Follow::where('follower_id', $authId)->where('followed_id', $uid)->first();
        if ($check === null) {
            $follow = new Follow();
            $follow->follower_id = $authId;
            $follow->followed_id = $uid;
            $follow->save();
            return redirect('/');
        } else {
            Follow::where('follower_id', $authId)->where('followed_id', $uid)->delete();
            return redirect('/');
        }
    }
    public function viewNotification()
    {
        $data = Notification::where('to',Auth::user()->email)->get();
        return view('notification',compact('data'));
    }
}
