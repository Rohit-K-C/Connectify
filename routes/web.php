<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\{AdminController, CombinedController, CommentController, ContentBasedController, EmojiController, HomePageController, LoginController, PostsController, UsersContoller, ProfileController, LikeController, MessagesController, SearchController, UserSimilarities};
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

//using facades to get data from database

// Route::get('/', function () {
//     $posts = DB::table('posts')->get();
//     return view('home', ['posts' => $posts]);
// });

//using eloquent model to retrieve data from database
// Route::get('/', [DashboardController::class, 'index'])->middleware('auth');


Route::get('/', [CombinedController::class, 'index'])->name('homepage.index');

// Route::get('/', [HomePageController::class, 'index']);


Route::match(['GET', 'POST'], '/logout', [LoginController::class, 'logout']);




// Route::get('/notification', function () {
//     return view('notification');
// });
// Route::get('/message', function () {
//     return view('message');
// });


Route::get('/message-box', [MessagesController::class, 'messageBox']);
Route::get('/message/{id}', [MessagesController::class, 'viewMessages'])->name('user.message');
Route::post('/send-message', [MessagesController::class, 'sendMessage'])->name('send.message');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/login', [LoginController::class, 'create']);

Route::post('/createUser', [UsersContoller::class, 'store']);
Route::get('/createUser', [UsersContoller::class, 'create']);

Route::post('/addQuestion', [PostsController::class, 'store']);
Route::get('/addQuestion', [PostsController::class, 'create']);
Route::get('/profile', [ProfileController::class, 'index']);
// Route::get('/user/profile/{user_id}', [ProfileController::class,'showProfile'])->name('user.profile');
// Route::get('/calculate-similarities', [UserSimilarities::class, 'calculateUserSimilarities']);

Route::get('/calculate-user-similarities', [UserSimilarities::class, 'calculateUserSimilarities'])->name('calculateUserSimilarities');
Route::get('/generate-recommendations/{userId}', [UserSimilarities::class, 'generateUsersRecommendation'])->name('generateUsersRecommendation');

Route::get('/content-based-recommendations', [ContentBasedController::class, 'generateContentBasedRecommendations'])->name('contentBasedRecommendations');





Route::get('/emojis', [EmojiController::class, 'getEmojis'])->name('emojis.index');



Route::post('/upload-image', [ProfileController::class, 'upload'])->name('upload-image.upload');
Route::post('/unfollow', [ProfileController::class, 'unfollow']);
Route::post('/follow', [ProfileController::class, 'follow']);



// Route::post('/like/{postId}', [LikeController::class, 'like']);
// Route::post('/unlike/{postId}', [LikeController::class, 'unlike']);
Route::post('/like/{postId}', [LikeController::class, 'like'])->name('like.post');




Route::get('/check_like/{postId}/{userId}', 'LikesController@checkLike');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/admin', [AdminController::class, 'index']);


// Route::get('/user/{username}', [UsersContoller::class, 'showProfile'])->name('user.profile');
Route::get('/user/{encodedUsername}', [UsersContoller::class, 'showProfile'])->name('user.profile');
Route::post('/user/fu', [UsersContoller::class, 'fuCheck']);



// admin dashboard link routes
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/manage-user', [AdminController::class, 'manageUser'])->name('manage-user');
Route::delete('/users/{user}', [UsersContoller::class, 'destroy'])->name('users.destroy');
Route::post('/users/{user}', [UsersContoller::class,'update'])->name('users.update');

Route::get('/manage-post', [AdminController::class, 'managePost'])->name('manage-post');
Route::delete('/posts/{post}', [PostsController::class, 'destroy'])->name('posts.destroy');
Route::post('/posts/{post}', [PostsController::class,'update'])->name('posts.update');
Route::post('/submit-comment', [CommentController::class,'comment'])->name('submit-comment.comment');


Route::get('/analytics', function () {
    return view('analytics');
})->name('analytics');

Route::get('/notification', [AdminController::class, 'notify'])->name('notification');
Route::post('/notify', [AdminController::class, 'sendNotification'])->name('send.notification');
Route::get('/viewnotification', [UsersContoller::class, 'viewNotification']);

// Route::get('/notify', function () {
//     return view('notify');
// })->name('notify');
