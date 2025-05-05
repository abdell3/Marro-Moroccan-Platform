<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\SavePost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SavePost>
 */
class SavePostFactory extends Factory
{
    protected $model = SavePost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $post = Post::inRandomOrder()->first();
        if (!$user) {
            $userId = 1;
        } else {
            $userId = $user->id;
        }
        if (!$post) {
            $postId = 1;
        } else {
            $postId = $post->id;
        }
        return [
            'user_id' => $userId,
            'post_id' => $postId,
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at' => now(),
        ];
    }

    public function recent()
    {
        return $this->state(function () {
            return [
                'created_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
                'updated_at' => now(),
            ];
        });
    }
    
    public function byUser($userId)
    {
        return $this->state(function () use ($userId) {
            return [
                'user_id' => $userId,
            ];
        });
    }
    
    public function forPost($postId)
    {
        return $this->state(function () use ($postId) {
            return [
                'post_id' => $postId,
            ];
        });
    }
}
