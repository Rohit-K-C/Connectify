<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    public function dashboard()
    {
        $totalUsers = User::count();
        $startDate = Carbon::now()->subDays(7); // Calculate the date 7 days ago

        $newUsers = User::where('created_at', '>=', $startDate)
            ->count();
        $totalPosts = Post::count();
        $postStartDate = Carbon::now()->subDays(7); // Calculate the date 7 days ago

        $newPosts = Post::where('created_at', '>=', $postStartDate)
            ->count();
      
            return view('dashboard', [
                'totalUsers' => $totalUsers,
                'newUsers' => $newUsers,
                'totalPosts' => $totalPosts,
                'newPosts' => $newPosts,
            ]);
            
    }
    public function notify(){
        // $from =$request->input('from');
        // $to =$request->input('to');
        // $content = $request->input('content');
        // dd($request);
        // $notification = new Notification();
        // $notification->from = $from;
        // $notification->to = $to;
        // $notification->content = $content;
        // $notification->save();
        return view('notify');
    }
    public function sendNotification(Request $request)
    {
        // Retrieve form data
        $from = 'admin@gmail.com'; // You can set a default "From" address
        $to = $request->input('to');
        $content = $request->input('content');
        $notification = new Notification();
        $notification->from = $from;
        $notification->to = $to;
        $notification->content = $content;
        $notification->save();
        return redirect()->back()->with('success', 'Notification sent successfully!');
    }
}
