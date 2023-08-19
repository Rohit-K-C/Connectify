<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(30)
            ->has(Post::factory()->count(10)) // Create 10 liked posts for each user
            ->create();
    }
}
