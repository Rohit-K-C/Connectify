<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\{AdminController, HomePageController, LoginController, PostsController, UsersContoller, ProfileController, LikeController, SearchController};
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

//using facades to get data from database

// Route::get('/', function () {
//     $posts = DB::table('posts')->get();
//     return view('home', ['posts' => $posts]);
// });

//using eloquent model to retrieve data from database
// Route::get('/', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/', [HomePageController::class, 'index']);

Route::post('/logout', [LoginController::class, 'logout']);


Route::get('/notification', function () {
    return view('notification');
});
Route::get('/message', function () {
    return view('message');
});


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/login', [LoginController::class, 'create']);

Route::post('/createUser', [UsersContoller::class, 'store']);
Route::get('/createUser', [UsersContoller::class, 'create']);

Route::post('/addQuestion', [PostsController::class, 'store']);
Route::get('/addQuestion', [PostsController::class, 'create']);
Route::get('/profile', [ProfileController::class, 'index']);

Route::post('/like/{postId}', [LikeController::class, 'like']);
Route::post('/unlike/{postId}', [LikeController::class, 'unlike']);

Route::get('/check_like/{postId}/{userId}', 'LikesController@checkLike');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/admin', [AdminController::class, 'index']);


// Route::get('/user/{username}', [UsersContoller::class, 'showProfile'])->name('user.profile');
Route::get('/user/{encodedUsername}', [UsersContoller::class, 'showProfile'])->name('user.profile');



// admin dashboard link routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/manage-user', function () {
    return view('manage_user');
})->name('manage-user');

Route::get('/manage-post', function () {
    return view('manage_post');
})->name('manage-post');

Route::get('/analytics', function () {
    return view('analytics');
})->name('analytics');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');
