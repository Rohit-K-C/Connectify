<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    
public function search(Request $request)
{
    $query = $request->input('search');
    $results = User::where('user_name', 'LIKE', "%$query%")->pluck('user_name');
    return response()->json($results);
}
}
