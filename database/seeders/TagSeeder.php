<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            
            [
                'title' => 'Discussion',
                'description' => 'Pour les posts qui visent à engager une conversation générale',
            ],
            [
                'title' => 'Question',
                'description' => 'Pour demander de l\'aide ou des informations',
            ],
            [
                'title' => 'Actualité',
                'description' => 'Pour partager des nouvelles et événements récents',
            ],
            [
                'title' => 'Humour',
                'description' => 'Pour les posts drôles et légers',
            ],
            [
                'title' => 'Mème',
                'description' => 'Pour les images et références humoristiques de la culture internet',
            ],
            [
                'title' => 'Débat',
                'description' => 'Pour les sujets controversés nécessitant différents points de vue',
            ],
            [
                'title' => 'AMA',
                'description' => 'Ask Me Anything - Pour les séances de questions-réponses ouvertes',
            ],
            [
                'title' => 'Sondage',
                'description' => 'Pour recueillir les opinions de la communauté',
            ],
            [
                'title' => 'NSFW',
                'description' => 'Not Safe For Work - Contenu sensible ou pour adultes',
            ],
            
         
            [
                'title' => 'Technologie',
                'description' => 'Discussions sur les innovations et gadgets technologiques',
            ],
            [
                'title' => 'Programmation',
                'description' => 'Tout ce qui concerne le code et le développement logiciel',
            ],
            [
                'title' => 'Jeux',
                'description' => 'Pour les discussions sur les jeux vidéo, jeux de société, etc.',
            ],
            [
                'title' => 'Sports',
                'description' => 'Actualités et discussions sur tous les sports',
            ],
            [
                'title' => 'Politique',
                'description' => 'Discussions sur la politique nationale et internationale',
            ],
            [
                'title' => 'Science',
                'description' => 'Découvertes et discussions scientifiques',
            ],
            [
                'title' => 'Art',
                'description' => 'Partage et discussions sur les créations artistiques',
            ],
            [
                'title' => 'Musique',
                'description' => 'Tout ce qui concerne la musique, les artistes et les albums',
            ],
            
            
            [
                'title' => 'Vidéo',
                'description' => 'Pour les posts contenant principalement une vidéo',
            ],
            [
                'title' => 'Image',
                'description' => 'Pour les posts contenant principalement une image',
            ],
            [
                'title' => 'Lien',
                'description' => 'Pour les posts partageant un lien externe',
            ],
            [
                'title' => 'Texte',
                'description' => 'Pour les posts constitués principalement de texte',
            ],
            [
                'title' => 'Tutoriel',
                'description' => 'Guides étape par étape pour apprendre quelque chose',
            ],
            
          
            [
                'title' => 'Résolu',
                'description' => 'Pour marquer les questions qui ont trouvé une réponse',
            ],
            [
                'title' => 'Tendance',
                'description' => 'Sujets populaires du moment',
            ],
            [
                'title' => 'Controversé',
                'description' => 'Contenus qui divisent l\'opinion',
            ],
            
            
            [
                'title' => 'Annonce',
                'description' => 'Communications officielles de la plateforme',
            ],
            [
                'title' => 'Règles',
                'description' => 'Posts concernant les règles de la communauté',
            ],
            [
                'title' => 'Meta',
                'description' => 'Discussions à propos de la plateforme elle-même',
            ],
            [
                'title' => 'Original',
                'description' => 'Contenu créé par l\'utilisateur lui-même',
            ],
            [
                'title' => 'Spoiler',
                'description' => 'Contient des révélations sur un film, livre, jeu, etc.',
            ],
        ];
        
        
        Tag::upsert($tags, ['title'], ['description']);
    }
}
