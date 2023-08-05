<?php

namespace App\Models;

use Dotenv\Repository\Adapter\GuardedWriter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'posts';
    protected $guarded = ['post_id', 'posted_by']; // Update to use 'post_id'

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
    public function isLikedBy(User $user, $postId)
    {
        return $this->likes()
            ->join('users', 'likes.user_id', '=', 'users.id')
            ->where('likes.post_id', $postId)
            ->where('likes.user_id', $user->id)
            ->exists();
    }
    // public function isLikedBy(User $user, $postId)
    // {
    //     return $this->likes()
    //         ->join('users', 'likes.user_id', '=', 'users.id')
    //         ->where('likes.post_id', $postId)
    //         ->where('likes.user_id', $user->id)
    //         ->exists();
    // }
    
    

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
}
