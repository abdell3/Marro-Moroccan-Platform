<?php

namespace Database\Factories;

use App\Models\Badge;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roleUser = Role::where('role_name', 'Utilisateur')->first();
        
        $badgeId = Badge::inRandomOrder()->first()?->id;
        $roleId = $roleUser ? $roleUser->id : 3;
        
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role_id' => $roleId,
            'token' => null,
            'avatar' => 'avatars/default.png',
            'preferences' => null,
            'remember_token' => Str::random(10),
        ];
    }
    
    public function admin()
    {
        return $this->state(function () {
            $roleAdmin = Role::where('role_name', 'Admin')->first();
            $roleId = $roleAdmin ? $roleAdmin->id : 1;
            
            return [
                'role_id' => $roleId,
                'avatar' => 'avatars/admin.png',
            ];
        });
    }
    

    public function moderator()
    {
        return $this->state(function () {
            $roleMod = Role::where('role_name', 'Moderateur')->first();
            $roleId = $roleMod ? $roleMod->id : 2;
            
            return [
                'role_id' => $roleId,
                'avatar' => 'avatars/moderator.png',
            ];
        });
    }

    public function unverified(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
