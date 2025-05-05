<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\SavePost;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavePostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->checkPrerequisites();
        $users = User::all();
        $posts = Post::all();
        $avgSavesPerUser = 5;
        foreach ($users as $user) {
            $numberOfSaves = rand(0, min($avgSavesPerUser * 2, $posts->count()));
            
            if ($numberOfSaves === 0) {
                continue;
            }

            $postsToSave = $posts->random($numberOfSaves);
            $savedPostIds = [];
            
            foreach ($postsToSave as $post) {
                if (in_array($post->id, $savedPostIds)) {
                    continue;
                }

                $exists = SavePost::where('user_id', $user->id)
                                 ->where('post_id', $post->id)
                                 ->exists();
                
                if ($exists) {
                    continue;
                }

                $savePost = SavePost::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'created_at' => now()->subDays(rand(0, 90)),
                    'updated_at' => now(),
                ]);
                $savedPostIds[] = $post->id;
            }
        }
        $this->createRecentSaves();
    }
    
    private function createRecentSaves(): void
    {
        $users = User::inRandomOrder()->limit(5)->get();
        $recentPosts = Post::orderBy('created_at', 'desc')->limit(10)->get();
        
        if ($users->isEmpty() || $recentPosts->isEmpty()) {
            return;
        }
        
        foreach ($users as $user) {
            $numberOfRecentSaves = rand(1, min(3, $recentPosts->count()));
            $postsToSave = $recentPosts->random($numberOfRecentSaves);
            
            foreach ($postsToSave as $post) {
                $exists = SavePost::where('user_id', $user->id)
                                 ->where('post_id', $post->id)
                                 ->exists();
                
                if ($exists) {
                    continue;
                }
                
                $savePost = SavePost::factory()->recent()->create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
    
    private function checkPrerequisites(): void
    {
        if (User::count() === 0) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez d\'abord exécuter le seeder d\'utilisateurs.');
            exit;
        }
        if (Post::count() === 0) {
            $this->command->error('Aucun post trouvé. Veuillez d\'abord exécuter le seeder de posts.');
            exit;
        }
    }
}
