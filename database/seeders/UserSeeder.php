<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Community;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $adminRoleId = Role::where('role_name', 'Admin')->first()?->id;
        $moderateurRoleId = Role::where('role_name', 'Moderateur')->first()?->id;
        $userRoleId = Role::where('role_name', 'Utilisateur')->first()?->id;
        
        // $adminRoleId = $adminRoleId ?? 1;
        $moderateurRoleId = $moderateurRoleId ?? 2;
        $userRoleId = $userRoleId ?? 3;

        $welcomeBadgeId = Badge::where('name', 'Welcome')->first()?->id;
        // $adminBadgeId = Badge::where('name', 'Admin')->first()?->id;
        $modBadgeId = Badge::where('name', 'Moderator')->first()?->id;

        // $admin = User::create([
        //     'nom' => 'Abdell',
        //     'prenom' => 'Abdo',
        //     'email' => 'abdo.abdell.2000@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('MyPlatform159'),
        //     'role_id' => $adminRoleId,
        //     'avatar' => 'avatars/admin.png',
        //     'preferences' => null,
        //     'remember_token' => null,
        // ]);
        
        // Attacher le badge Admin à l'administrateur
        // if ($adminBadgeId) {
        //     $admin->badges()->attach($adminBadgeId, ['earned_at' => now()]);
        // }
        $moderateurs = User::factory()->moderator()->count(10)->create([
            'role_id' => $moderateurRoleId
        ]);
        
        if ($modBadgeId) {
            foreach ($moderateurs as $mod) {
                $mod->badges()->attach($modBadgeId, ['earned_at' => now()]);
            }
        }
        
        $users = User::factory()->count(50)->create([
            'role_id' => $userRoleId
        ]);
        if ($welcomeBadgeId) {
            foreach ($users as $user) {
                $user->badges()->attach($welcomeBadgeId, ['earned_at' => now()]);
            }
        }
        $communities = Community::all();
        
        if ($communities->count() == 0) {
            $themes = ['Technologie', 'Cuisine', 'Jeux Vidéo', 'Sports', 'Cinéma', 'Musique', 'Littérature', 'Voyage', 'Science', 'Art'];
            foreach ($moderateurs as $index => $mod) {
                $theme = $themes[$index % count($themes)];
                $community = Community::create([
                    'creator_id' => $mod->id,
                    'theme_name' => $theme,
                    'description' => 'Ceci est une communauté créée par ' . $mod->prenom . ' dédiée à ' . $theme,
                    'rules' => "1. Soyez gentils\n2. Pas d'insultes",
                ]);
            
          
                $mod->communities()->attach($community->id);
            }
        
        
            $communities = Community::all();
        }
    
        foreach ($users as $user) {
            $nbCommunities = rand(1, 5);
            $communitiesIds = $communities->random($nbCommunities)->pluck('id');
        
            $user->communities()->attach($communitiesIds);
        }
    
        // $admin->communities()->attach($communities->pluck('id'));
    }   

    
}
