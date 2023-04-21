<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $user->remember_token = $request->_token;
        $user->save();
        return redirect('/login');
    }
    


}
