<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Community>
 */
class CommunityFactory extends Factory
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
        
        
        $themes = [
            'Technology', 'Programming', 'Gaming', 'Movies',
            'Music', 'Books', 'Science', 'Art', 'Food',
            'Travel', 'Sports', 'Fitness', 'Photography'
        ];
        
        return [
            'creator_id' => $userId,
            'theme_name' => $this->faker->randomElement($themes) . ' ' . $this->faker->word,
            'description' => $this->faker->paragraph,
            'rules' => $this->faker->sentence . "\n" . $this->faker->sentence,
            'icon' => 'communities/default.png',
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
        
    }
}
