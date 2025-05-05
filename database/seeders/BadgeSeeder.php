<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            
            [
                'nom' => 'Welcome',
                'critere' => 'S\'inscrire sur la plateforme',
                'logo' => 'badges/welcome.png',
            ],
            [
                'nom' => 'Explorer',
                'critere' => 'Visiter au moins 10 communautés différentes',
                'logo' => 'badges/explorer.png',
            ],
            [
                'nom' => 'Active Voter',
                'critere' => 'Voter sur au moins 50 posts',
                'logo' => 'badges/voter.png',
            ],
            [
                'nom' => 'Commentator',
                'critere' => 'Publier au moins 25 commentaires',
                'logo' => 'badges/commentator.png',
            ],
            [
                'nom' => 'Night Owl',
                'critere' => 'Être actif régulièrement entre minuit et 5h du matin',
                'logo' => 'badges/night_owl.png',
            ],
            
            
            [
                'nom' => 'First Post',
                'critere' => 'Créer son premier post',
                'logo' => 'badges/first_post.png',
            ],
            [
                'nom' => 'Prolific Poster',
                'critere' => 'Créer plus de 50 posts',
                'logo' => 'badges/prolific.png',
            ],
            [
                'nom' => 'Content Creator',
                'critere' => 'Avoir au moins 5 posts avec plus de 100 likes',
                'logo' => 'badges/creator.png',
            ],
            [
                'nom' => 'Viral',
                'critere' => 'Avoir un post avec plus de 1000 likes',
                'logo' => 'badges/viral.png',
            ],
            
        
            [
                'nom' => 'Community Builder',
                'critere' => 'Créer une communauté',
                'logo' => 'badges/builder.png',
            ],
            [
                'nom' => 'Popular Community',
                'critere' => 'Créer une communauté avec plus de 100 membres',
                'logo' => 'badges/popular.png',
            ],
            [
                'nom' => 'Trended',
                'critere' => 'Avoir un post qui apparaît dans les tendances',
                'logo' => 'badges/trending.png',
            ],
            
           
            [
                'nom' => 'First Year',
                'critere' => 'Être membre actif depuis 1 an',
                'logo' => 'badges/first_year.png',
            ],
            [
                'nom' => 'Veteran',
                'critere' => 'Être membre actif depuis 3 ans',
                'logo' => 'badges/veteran.png',
            ],
            [
                'nom' => 'OG Member',
                'critere' => 'Être membre depuis le lancement de la plateforme',
                'logo' => 'badges/og.png',
            ],

            [
                'nom' => 'Moderator',
                'critere' => 'Modérer une communauté',
                'logo' => 'badges/moderator.png',
            ],
            [
                'nom' => 'Super Moderator',
                'critere' => 'Modérer au moins 3 communautés différentes',
                'logo' => 'badges/super_mod.png',
            ],
            [
                'nom' => 'Report Hero',
                'critere' => 'Signaler correctement au moins 20 contenus inappropriés',
                'logo' => 'badges/report_hero.png',
            ],
            
         
            [
                'nom' => 'Verified',
                'critere' => 'Avoir un compte vérifié par l\'administration',
                'logo' => 'badges/verified.png',
            ],
            [
                'nom' => 'Daily Streak',
                'critere' => 'Se connecter 30 jours consécutifs',
                'logo' => 'badges/streak.png',
            ],
            [
                'nom' => 'Tech',
                'critere' => 'Être particulièrement actif et apprécié dans les communautés technologiques',
                'logo' => 'badges/tech.png',
            ],
            [
                'nom' => 'Gamer',
                'critere' => 'Être particulièrement actif dans les communautés de jeux vidéo',
                'logo' => 'badges/gamer.png',
            ],
            [
                'nom' => 'Art Enthusiast',
                'critere' => 'Contribuer régulièrement aux communautés artistiques',
                'logo' => 'badges/art.png',
            ],
        ];
        
        
        Badge::upsert($badges, ['nom'], ['critere', 'logo']);
    }
}
