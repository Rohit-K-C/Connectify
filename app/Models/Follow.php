<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'follows';
    protected $fillable = [
        'follower_id', 'followed_id',
    ];
    public function isFollowing($followerId, $followedId)
    {
        return Follow::where('follower_id', $followerId)
            ->where('followed_id', $followedId)
            ->exists();
    }
}
