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
                'name' => 'Welcome',
                'description' => 'Badge attribué à tous les nouveaux membres',
                'criteria' => 'S\'inscrire sur la plateforme',
                'icon' => 'badges/welcome.png',
            ],
            [
                'name' => 'Explorer',
                'description' => 'Découvrez différentes communautés sur la plateforme',
                'criteria' => 'Visiter au moins 10 communautés différentes',
                'icon' => 'badges/explorer.png',
            ],
            [
                'name' => 'Active Voter',
                'description' => 'Participez activement en votant sur les publications',
                'criteria' => 'Voter sur au moins 50 posts',
                'icon' => 'badges/voter.png',
            ],
            [
                'name' => 'Commentator',
                'description' => 'Contribuez aux discussions avec vos commentaires',
                'criteria' => 'Publier au moins 25 commentaires',
                'icon' => 'badges/commentator.png',
            ],
            [
                'name' => 'Night Owl',
                'description' => 'Actif pendant les heures tardives',
                'criteria' => 'Être actif régulièrement entre minuit et 5h du matin',
                'icon' => 'badges/night_owl.png',
            ],
            
            [
                'name' => 'First Post',
                'description' => 'Vous avez fait votre première publication',
                'criteria' => 'Créer son premier post',
                'icon' => 'badges/first_post.png',
            ],
            [
                'name' => 'Prolific Poster',
                'description' => 'Contributeur régulier avec de nombreuses publications',
                'criteria' => 'Créer plus de 50 posts',
                'icon' => 'badges/prolific.png',
            ],
            [
                'name' => 'Content Creator',
                'description' => 'Créateur de contenu populaire et apprécié',
                'criteria' => 'Avoir au moins 5 posts avec plus de 100 likes',
                'icon' => 'badges/creator.png',
            ],
            [
                'name' => 'Viral',
                'description' => 'Votre contenu a connu un succès viral',
                'criteria' => 'Avoir un post avec plus de 1000 likes',
                'icon' => 'badges/viral.png',
            ],
            
    
            [
                'name' => 'Community Builder',
                'description' => 'Vous avez créé votre propre communauté',
                'criteria' => 'Créer une communauté',
                'icon' => 'badges/builder.png',
            ],
            [
                'name' => 'Popular Community',
                'description' => 'Votre communauté attire de nombreux membres',
                'criteria' => 'Créer une communauté avec plus de 100 membres',
                'icon' => 'badges/popular.png',
            ],
            [
                'name' => 'Trended',
                'description' => 'Votre contenu a atteint les tendances',
                'criteria' => 'Avoir un post qui apparaît dans les tendances',
                'icon' => 'badges/trending.png',
            ],
           
            [
                'name' => 'First Year',
                'description' => 'Membre fidèle depuis un an',
                'criteria' => 'Être membre actif depuis 1 an',
                'icon' => 'badges/first_year.png',
            ],
            [
                'name' => 'Veteran',
                'description' => 'Membre de longue date de notre communauté',
                'criteria' => 'Être membre actif depuis 3 ans',
                'icon' => 'badges/veteran.png',
            ],
            [
                'name' => 'OG Member',
                'description' => 'Membre fondateur de la communauté',
                'criteria' => 'Être membre depuis le lancement de la plateforme',
                'icon' => 'badges/og.png',
            ],
            
            
            [
                'name' => 'Moderator',
                'description' => 'Aide à maintenir une communauté positive',
                'criteria' => 'Modérer une communauté',
                'icon' => 'badges/moderator.png',
            ],
            [
                'name' => 'Super Moderator',
                'description' => 'Modérateur expérimenté de plusieurs communautés',
                'criteria' => 'Modérer au moins 3 communautés différentes',
                'icon' => 'badges/super_mod.png',
            ],
            [
                'name' => 'Report Hero',
                'description' => 'Contribue activement à maintenir les standards de la plateforme',
                'criteria' => 'Signaler correctement au moins 20 contenus inappropriés',
                'icon' => 'badges/report_hero.png',
            ],
            
            [
                'name' => 'Admin',
                'description' => 'Etre admin c\'est bien ',
                'criteria' => 'Je suis le createur de cette platform j\'ai pas besoin de critere .',
                'icon' => 'badgess/admin.png'
            ],
      
            [
                'name' => 'Verified',
                'description' => 'Compte authentifié par l\'équipe d\'administration',
                'criteria' => 'Avoir un compte vérifié par l\'administration',
                'icon' => 'badges/verified.png',
            ],
            [
                'name' => 'Daily Streak',
                'description' => 'Utilisateur assidu qui se connecte quotidiennement',
                'criteria' => 'Se connecter 30 jours consécutifs',
                'icon' => 'badges/streak.png',
            ],
            
            
            [
                'name' => 'Tech',
                'description' => 'Contributeur actif dans les communautés technologiques',
                'criteria' => 'Être particulièrement actif et apprécié dans les communautés technologiques',
                'icon' => 'badges/tech.png',
            ],
            [
                'name' => 'Gamer',
                'description' => 'Passionné de jeux vidéo qui participe activement',
                'criteria' => 'Être particulièrement actif dans les communautés de jeux vidéo',
                'icon' => 'badges/gamer.png',
            ],
            [
                'name' => 'Art Enthusiast',
                'description' => 'Passionné d\'art qui enrichit les communautés artistiques',
                'criteria' => 'Contribuer régulièrement aux communautés artistiques',
                'icon' => 'badges/art.png',
            ],
        ];
        Badge::upsert($badges, ['name'], ['description', 'criteria', 'icon']);
    }
}
