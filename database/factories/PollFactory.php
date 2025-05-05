<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $userId = $user ? $user->id : 1;
        $post = Post::where('typeContenu', 'poll')->inRandomOrder()->first();

        if (!$post) {
            $post = Post::inRandomOrder()->first();
        }

        $postId = $post ? $post->id : 1;
        $typeVote = $this->faker->randomElement(['single', 'multiple', 'updown', 'rating']);
        
        return [
            'auteur_id' => $userId,
            'post_id' => $postId,
            'typeVote' => $typeVote,
            'created_at' => $post ? $post->created_at : now(),
            'updated_at' => $post ? $post->updated_at : now(),
        ];
    }
    public function singleChoice()
    {
        return $this->state(function() {
            return [
                'typeVote' => 'single',
            ];
        });
    }
    
    public function multipleChoice()
    {
        return $this->state(function() {
            return [
                'typeVote' => 'multiple',
            ];
        });
    }

    public function updownVote()
    {
        return $this->state(function() {
            return [
                'typeVote' => 'updown',
            ];
        });
    }
}
