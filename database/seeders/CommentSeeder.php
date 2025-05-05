<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        $users = User::all();
        
        foreach ($posts as $post) {
            $nbComments = rand(0, 5);
            if ($nbComments > 0) {
                for ($i = 0; $i < $nbComments; $i++) {
                    $user = $users->random();
                    $comment = Comment::create([
                        'post_id' => $post->id,
                        'auteur_id' => $user->id,
                        'contenu' => $this->getRandomComment(),
                        'datePublication' => now()->subMinutes(rand(1, 60 * 24 * 30)), 
                    ]);
                    if (rand(1, 100) <= 30) {
                        $responder = $users->random();
                        while ($responder->id == $user->id && $users->count() > 1) {
                            $responder = $users->random();
                        }
                        Comment::create([
                            'post_id' => $post->id,
                            'auteur_id' => $responder->id,
                            'parent_id' => $comment->id,
                            'contenu' => $this->getRandomReply(),
                            'datePublication' => now()->subMinutes(rand(1, 60 * 24 * 15)), 
                        ]);
                    }
                }
            }
        }
        Comment::factory()->count(20)->create();
        Comment::factory()->reply()->count(10)->create();
        
    }

    private function getRandomComment()
    {
        $comments = [
            "Super post, merci pour l'info!",
            "Je ne suis pas d'accord avec certains points mentionnés.",
            "Est-ce que quelqu'un peut m'expliquer mieux ce sujet?",
            "C'est exactement ce que je cherchais depuis longtemps.",
            "Intéressant, mais j'aurais aimé plus de détails.",
            "Première fois que j'entends parler de ça, merci!",
            "Ce post mérite plus d'attention.",
            "Je pense que vous avez oublié de mentionner un aspect important.",
            "Quelqu'un a-t-il déjà essayé cette méthode?",
            "Je vais partager ça avec mes amis, c'est super utile."
        ];
        
        return $comments[array_rand($comments)];
    }
    
    private function getRandomReply()
    {
        $replies = [
            "Je suis tout à fait d'accord avec vous!",
            "Non, ce n'est pas exact. En fait...",
            "Merci pour votre point de vue, je n'y avais pas pensé.",
            "Pouvez-vous développer davantage?",
            "Oui, j'ai eu la même expérience.",
            "Intéressant! Je vais essayer ça.",
            "Vous avez une source pour cette information?",
            "Je comprends votre point, mais je pense différemment.",
            "Exactement ce que je voulais dire!",
            "Merci d'avoir partagé votre expérience."
        ];
        
        return $replies[array_rand($replies)];
    }
}