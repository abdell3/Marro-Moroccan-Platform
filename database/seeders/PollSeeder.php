<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        
        $users = User::all();
        $pollPosts = Post::where('typeContenu', 'poll')->get();

        if ($pollPosts->count() == 0) {
            for ($i = 0; $i < 3; $i++) {
                $user = $users->random();
                $community = $user->communities->first();
                if (!$community) {
                    continue;
                }
                $pollQuestions = [
                    'Quel est votre langage de programmation préféré?',
                    'Préférez-vous travailler en remote ou au bureau?',
                    'Quel est votre framework JavaScript favori?',
                    'Quelle est la meilleure distro Linux selon vous?',
                    'Vim ou Emacs?'
                ];
                $post = Post::create([
                    'titre' => $pollQuestions[array_rand($pollQuestions)],
                    'contenu' => 'Votez pour donner votre avis!',
                    'typeContenu' => 'poll',
                    'datePublication' => now()->subDays(rand(1, 30)),
                    'auteur_id' => $user->id,
                    'community_id' => $community->id,
                    'like' => rand(5, 50),
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
                $pollPosts->push($post);
                echo "  - Création du post de sondage: {$post->titre}\n";
            }
        }

        foreach ($pollPosts as $post) {
            $typeVotes = [
                'single' => 60,   
                'multiple' => 20,  
                'updown' => 10,    
                'rating' => 10
            ];

            $rand = rand(1, 100);
            $cumulative = 0;
            $selectedType = 'single'; 
            
            foreach ($typeVotes as $type => $probability) {
                $cumulative += $probability;
                if ($rand <= $cumulative) {
                    $selectedType = $type;
                    break;
                }
            }
            
            $poll = Poll::create([
                'auteur_id' => $post->auteur_id,
                'post_id' => $post->id,
                'typeVote' => $selectedType,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ]);

            $nbVotes = rand(5, 30); 

            $voteValues = [];
            
            switch ($selectedType) {
                case 'single':
                    $voteValues = ['Option A', 'Option B', 'Option C', 'Option D'];
                    break;
                case 'multiple':
                    $voteValues = ['Option A,Option C', 'Option B', 'Option A,Option B,Option D', 'Option C,Option D'];
                    break;
                case 'updown':
                    $voteValues = ['up', 'down'];
                    break;
                case 'rating':
                    $voteValues = ['1', '2', '3', '4', '5'];
                    break;
            }
            
            $votedUsers = [];
            
            for ($i = 0; $i < $nbVotes; $i++) {
                $voter = null;
                $attempts = 0;
                
                while ($attempts < 10) {
                    $randomUser = $users->random();
                    if (!in_array($randomUser->id, $votedUsers)) {
                        $voter = $randomUser;
                        $votedUsers[] = $voter->id;
                        break;
                    }
                    $attempts++;
                }
                if (!$voter) {
                    continue;
                }
                $poll->voters()->attach($voter->id, [
                    'vote_value' => $voteValues[array_rand($voteValues)],
                    'created_at' => $post->created_at->addMinutes(rand(10, 60 * 24 * 5)), 
                    'updated_at' => now(),
                ]);
            }
        }
    
        $nbRandomPolls = 5;
        $randomPosts = $posts->where('typeContenu', '!=', 'poll')->random(min($nbRandomPolls, $posts->where('typeContenu', '!=', 'poll')->count()));
        
        foreach ($randomPosts as $post) {
            $post->update(['typeContenu' => 'poll']);
            $poll = Poll::factory()->create([
                'post_id' => $post->id,
                'auteur_id' => $post->auteur_id,
            ]);
            $voters = $users->random(rand(3, 10));
            
            foreach ($voters as $voter) {
                $voteValue = 'Option A';
                if ($poll->typeVote == 'multiple') {
                    $voteValue = rand(0, 1) ? 'Option A,Option B' : 'Option C';
                } elseif ($poll->typeVote == 'updown') {
                    $voteValue = rand(0, 1) ? 'up' : 'down';
                } elseif ($poll->typeVote == 'rating') {
                    $voteValue = (string)rand(1, 5);
                }
                $poll->voters()->attach($voter->id, [
                    'vote_value' => $voteValue,
                    'created_at' => $post->created_at->addMinutes(rand(10, 60 * 24 * 3)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
