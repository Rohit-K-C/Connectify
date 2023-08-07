<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\ProfileImage;
use App\Models\User;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $likesData = Like::pluck('total_likes', 'post_id')->toArray();
        $posts = Post::where('user_id', $user_id)->get();
        $user = User::with(['profileImage', 'followers', 'followedUsers'])->find($user_id);

        $totalFollowers = $user->followers()->count();
        $totalFollowing = $user->followedUsers()->count();

        return view('profile', [
            'posts' => $posts,
            'likesData' => $likesData,
            'user' => $user,
            'totalFollowers' => $totalFollowers,
            'totalFollowing' => $totalFollowing,
        ]);
    }

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'contact' => 'required|digits:10',
            'user_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $id = auth()->user()->id;
        $user = User::find($id);
        if ($user) {
            $user->user_name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->contact = $validatedData['contact'];
            $user->save();
        } else {
            return redirect()->back()->with('error', 'User not authenticated.');
        }

        $image = new ProfileImage();
        $image->user_id = auth()->user()->id;
        $imageName = time() . '.' . $request->file('user_image')->getClientOriginalExtension();
        $request->file('user_image')->move(public_path('images'), $imageName);
        $image->user_image = 'images/' . $imageName;

        // Use updateOrCreate to handle insert or update
        ProfileImage::updateOrCreate(
            ['user_id' => $image->user_id], // Find record by user_id
            ['user_image' => $image->user_image] // Update or insert user_image
        );

        return redirect()->back()->with('success', 'Image uploaded and user data updated successfully.');
    }
    public function unfollow(Request $request)
    {
        $userId = $request->input('user_id');
        $followerId = auth()->user()->id;

        Follow::where('follower_id', $followerId)
            ->where('followed_id', $userId)
            ->delete();
        return back()->with('success', 'Unfollowed successfully');
    }
    public function follow(Request $request)
    {
        $followerId = $request->input('user_id'); //8
        $followedId = auth()->user()->id; //1

        // Check if the follow relationship already exists
        $existingFollow = Follow::where('follower_id', $followedId)
            ->where('followed_id', $followerId)
            ->first();

        if (!$existingFollow) {
            Follow::create([
                'follower_id' => $followedId,
                'followed_id' => $followerId,
            ]);

            return back()->with('success', 'Followed successfully');
        }

        return back()->with('error', 'You are already following this user');
    }
}
