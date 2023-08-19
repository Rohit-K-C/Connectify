<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Post; // Import the Post model
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'user_name' => $this->faker->userName,
            'email' => $this->generateShortUniqueEmail(),
            'password' => Hash::make('password'), 
            'contact' => '9803369854', 
            'is_admin' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->likedPosts()->saveMany(Post::factory(10)->create());
        });
    }

    protected function generateShortUniqueEmail()
    {
        do {
            $shortEmail = Str::random(3) . time() . '@example.com';
        } while (User::where('email', $shortEmail)->exists()); 

        return $shortEmail;
    }
}
