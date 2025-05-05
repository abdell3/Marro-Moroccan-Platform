<?php

namespace Database\Factories;

use App\Models\Community;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      
        $user = User::inRandomOrder()->first();
        $community = Community::inRandomOrder()->first();
        
        if (!$user) {
            $userId = 1;
        } else {
            $userId = $user->id;
        }
        if (!$community) {
            $communityId = 1;
        } else {
            $communityId = $community->id;
        }

        $threadTitles = [
            'Que pensez-vous de ' . $this->faker->word() . '?',
            'Discussion sur ' . $this->faker->sentence(3),
            'Besoin d\'aide avec ' . $this->faker->word(),
            'Parlons de ' . $this->faker->sentence(2),
            $this->faker->sentence(4) . '?',
            'Comment résoudre ' . $this->faker->sentence(3) . '?',
            'Nouvelle approche pour ' . $this->faker->words(3, true),
            'Conseils pour ' . $this->faker->words(2, true),
            'Partage d\'expérience : ' . $this->faker->sentence(3),
            'Question importante : ' . $this->faker->sentence(3)
        ];
        
        $title = $threadTitles[array_rand($threadTitles)];
        
        $paragraphs = $this->faker->paragraphs(rand(1, 5));
        $content = implode("\n\n", $paragraphs);
        
        return [
            'title' => $title,
            'content' => $content,
            'user_id' => $userId,
            'community_id' => $communityId,
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => function (array $attributes) {
                if (rand(1, 100) <= 25) {
                    return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
                }
                
                return $attributes['created_at'];
            },
        ];
    }
    
    public function recent()
    {
        return $this->state(function () {
            return [
                'created_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
                'updated_at' => function (array $attributes) {
                    if (rand(1, 100) <= 50) {
                        return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
                    }
                    return $attributes['created_at'];
                },
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

    public function inCommunity($communityId)
    {
        return $this->state(function () use ($communityId) {
            return [
                'community_id' => $communityId,
            ];
        });
    }
}
