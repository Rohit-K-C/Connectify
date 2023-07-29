<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('addQuestion');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dump(request()->all());
        $post = new Post;
        $post->post_info = $request->post_info;
        $post->user_id = $request->user_id;
        $imageName = time().'.'.$request->uploadfile->getClientOriginalExtension();
        $request->uploadfile->move(public_path('images'), $imageName);
        $post->post_image = 'images/'.$imageName;
        $post->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the post by ID and eager load the 'likes' relationship
        $post = Post::with('likes')->findOrFail($id);

        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
