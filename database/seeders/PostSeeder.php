<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $communities = Community::all();
        $tags = Tag::all();
        $hasTags = ($tags->count() > 0);
        $postsData = [
            [
                'titre' => 'Bienvenue dans notre communauté!',
                'contenu' => "Bonjour à tous,\n\nBienvenue dans notre communauté! N'hésitez pas à vous présenter et à partager vos idées.\n\nÀ bientôt!",
                'typeContenu' => 'text',
                'like' => 42
            ],
            [
                'titre' => 'Les meilleures astuces pour apprendre à coder',
                'contenu' => "Voici quelques astuces qui m'ont beaucoup aidé:\n1. Pratiquer tous les jours\n2. Travailler sur des projets personnels\n3. Rejoindre des communautés de développeurs\n4. Ne pas avoir peur de faire des erreurs",
                'typeContenu' => 'text',
                'like' => 156
            ],
            [
                'titre' => 'Regardez cette superbe photo!',
                'contenu' => null,
                'typeContenu' => 'image',
                'media_path' => 'images/posts/sunset.jpg',
                'media_type' => 'image/jpeg',
                'like' => 89
            ],
            [
                'titre' => 'Article intéressant sur le développement web',
                'contenu' => 'Voici un article qui explique les nouvelles tendances dans le développement web en 2023.',
                'typeContenu' => 'link',
                'media_path' => 'https://www.studi.com/fr/blog/les-actualites-metiers-formations/tendances-developpement-web-2024hf',
                'media_type' => 'link',
                'like' => 37
            ],
            [
                'titre' => 'Quelle est votre langage de programmation préféré?',
                'contenu' => 'Je suis curieux de savoir quel langage de programmation vous préférez et pourquoi.',
                'typeContenu' => 'poll',
                'like' => 203
            ],
        ];
 
        foreach ($postsData as $postData) {
            $user = $users->random();
            $community = $communities->random();
            
            $mediaPath = $postData['media_path'] ?? null;
            $mediaType = $postData['media_type'] ?? null;
      
            $date = now()->subDays(rand(1, 60));
            
            $post = Post::create([
                'titre' => $postData['titre'],
                'contenu' => $postData['contenu'],
                'typeContenu' => $postData['typeContenu'],
                'media_path' => $mediaPath,
                'media_type' => $mediaType,
                'datePublication' => $date,
                'auteur_id' => $user->id,
                'community_id' => $community->id,
                'like' => $postData['like'],
                'created_at' => $date,
                'updated_at' => $date
            ]);

            if ($hasTags) {
                $randomTags = $tags->random(rand(1, min(3, $tags->count())));
                $post->tags()->attach($randomTags->pluck('id')->toArray());
            }
        }
        
        $nbRandomPosts = 15; 
        Post::factory()
            ->count($nbRandomPosts)
            ->create()
            ->each(function ($post) use ($tags, $hasTags) {
                if ($hasTags) {
                    $nbTags = rand(0, min(5, $tags->count()));
                    if ($nbTags > 0) {
                        $randomTags = $tags->random($nbTags);
                        $post->tags()->attach($randomTags->pluck('id')->toArray());
                    }
                }
            });

        $nbPopularPosts = 5;
        Post::factory()
            ->popular()
            ->count($nbPopularPosts)
            ->create()
            ->each(function ($post) use ($tags, $hasTags) {
                if ($hasTags) {
                    $nbTags = rand(3, min(8, $tags->count()));
                    $randomTags = $tags->random($nbTags);
                    $post->tags()->attach($randomTags->pluck('id')->toArray());
                }
            });
    }
}
