<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $mods = User::where('role_id', 2)->get();
        
        
        if ($mods->count() == 0) {
            $admin = User::where('role_id', 1)->first();
            if ($admin) {
                $mods = [$admin];
            } else {
                echo "Erreur: Aucun modérateur ou admin trouvé. Exécutez d'abord le UserSeeder.\n";
                return;
            }
        }
        

        $communityData = [
            'Tech' => [
                'description' => 'Pour discuter de technologie',
                'rules' => "1. Partagez les sources de vos informations\n2. Pas de débats de marques toxiques\n3. Aidez les débutants"
            ],
            'Gaming' => [
                'description' => 'Les jeux vidéo',
                'rules' => "1. Pas de spoilers des nouveaux jeux\n2. Respectez les goûts des autres\n3. Partagez vos astuces"
            ],
            'Films' => [
                'description' => 'Cinéma et séries TV',
                'rules' => "1. Utilisez des balises spoiler\n2. Pas de liens illégaux\n3. Respectez les opinions sur les films"
            ],
            'Musique' => [
                'description' => 'Partager vos musiques préférées',
                'rules' => "1. Pas de piratage\n2. Écoutez les recommandations des autres\n3. Tous les genres sont bienvenus"
            ],
            'Sport' => [
                'description' => 'Actualités sportives',
                'rules' => "1. Pas d'insultes envers les équipes\n2. Restez fair-play\n3. Respectez tous les sports"
            ],
            'Science' => [
                'description' => 'Partage de découvertes scientifiques et discussions sur tous les domaines scientifiques',
                'rules' => "1. Sources fiables uniquement.\n2. Respectez le processus scientifique."
            ],
        ];
        
       
        $i = 0;
        foreach ($communityData as $name => $data) {
       
            $creator = $mods[$i % count($mods)];
            $i++;
            
            
            $community = Community::create([
                'creator_id' => $creator->id,
                'theme_name' => $name,
                'description' => $data['description'],
                'rules' => $data['rules'],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
            
    
            $creator->communities()->attach($community->id);
        }
        
        Community::factory()->count(5)->create();
    }
}
