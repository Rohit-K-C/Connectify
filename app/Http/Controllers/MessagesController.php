<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\ProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $recipient = $request->input('receiver_id');
        // Create a new message
        $message = new Message();
        $message->sender_id = $user->id;
        $message->receiver_id = $recipient;
        $message->content = $request->input('message_content');
        $message->save();

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    public function viewMessages($id)
    {
        $user = Auth::user();
        $otherUser = User::find($id);
        $otherUserProfileImage = ProfileImage::where('user_id', $id)->first();

        // Retrieve messages between the authenticated user and the other user (with ID $id)
        $messages = Message::where(function ($query) use ($user, $id) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $id);
        })
            ->orWhere(function ($query) use ($user, $id) {
                $query->where('sender_id', $id)
                    ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        return view('message', [
            'messages' => $messages,
            'otherUser' => $otherUser,
            'otherUserProfileImage' => $otherUserProfileImage
        ]);
    }

    public function messageBox()
    {
        $user = Auth::user();

        $following = $user->followedUsers;
        $followers = $user->followers;
        $commonUsers = $following->intersect($followers);
        $commonUsersWithImages = [];
        foreach ($commonUsers as $commonUser) {
            $profileImage = ProfileImage::where('user_id', $commonUser->id)->first();
            $commonUsersWithImages[] = [
                'user' => $commonUser,
                'profileImage' => $profileImage,
            ];
        }

        return view('messageBox', [
            'commonUsersWithImages' => $commonUsersWithImages,
        ]);
    }
}
