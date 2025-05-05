<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
        
        $community = Community::inRandomOrder()->first();
        $communityId = $community ? $community->id : 1;
        
        $typeContenu = $this->faker->randomElement(['text', 'image', 'video', 'link', 'poll']);
        
        $mediaPath = null;
        $mediaType = null;
        
        if ($typeContenu == 'image') {
            $imageFiles = ['sunset.jpg', 'nature.jpg', 'city.jpg', 'food.jpg', 'tech.jpg'];
            $mediaPath = 'posts/images/' . $this->faker->randomElement($imageFiles);
            $mediaType = 'image/jpeg';
        } elseif ($typeContenu == 'video') {
            $videoFiles = ['interview.mp4', 'tutorial.mp4', 'demo.mp4'];
            $mediaPath = 'posts/videos/' . $this->faker->randomElement($videoFiles);
            $mediaType = 'video/mp4';
        } elseif ($typeContenu == 'link') {
            $mediaPath = $this->faker->url;
            $mediaType = 'link';
        }
        $datePublication = $this->faker->dateTimeBetween('-3 months', 'now');
        
        return [
            'titre' => $this->faker->sentence,
            'contenu' => $typeContenu == 'text' ? $this->faker->paragraphs(3, true) : null,
            'typeContenu' => $typeContenu,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
            'datePublication' => $datePublication,
            'auteur_id' => $userId,
            'community_id' => $communityId,
            'like' => $this->faker->numberBetween(0, 500), 
            'created_at' => $datePublication, 
            'updated_at' => $datePublication,
        ];
    }

    public function textOnly()
    {
        return $this->state(function() {
            return [
                'typeContenu' => 'text',
                'contenu' => $this->faker->paragraphs(5, true),
                'media_path' => null,
                'media_type' => null,
            ];
        });
    }
    
    public function popular()
    {
        return $this->state(function() {
            return [
                'like' => $this->faker->numberBetween(500, 2000),
                'datePublication' => $this->faker->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }
}
