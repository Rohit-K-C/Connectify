<?php
namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'post_info' => $this->faker->paragraph,
            'post_image' => $this->faker->imageUrl(640, 480),
            'user_id' => User::factory(), // Make sure to import the User model at the top of the file
        ];
    }
}
