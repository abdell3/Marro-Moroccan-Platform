<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $post = Post::inRandomOrder()->first();
        $postId = $post ? $post->id : 1;
        
        $user = User::inRandomOrder()->first();
        $userId = $user ? $user->id : 1;
        
        return [
            'post_id' => $postId,
            'auteur_id' => $userId,
            'parent_id' => null,
            'contenu' => $this->faker->paragraph,
            'datePublication' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function reply()
    {
        return $this->state(function() {
            $parentComment = Comment::inRandomOrder()->first();
            if (!$parentComment) {
                return ['parent_id' => null];
            }
            return [
                'parent_id' => $parentComment->id,
                'post_id' => $parentComment->post_id,
                'contenu' => "En réponse à un commentaire: " . $this->faker->sentence,
            ];
        });
    }
}