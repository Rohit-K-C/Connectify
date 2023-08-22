<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $table = 'likes';
    public $timestamps = false;
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getLikeCountForPost($postId)
{
    $likeCount = $this->where('post_id', $postId)->count();

    return $likeCount;
}

}
