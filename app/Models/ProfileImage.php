<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    use HasFactory;
    protected $table = 'profileimage';
    protected $fillable = [
        'user_id', 'user_image', // Add 'user_image' to the fillable array
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
