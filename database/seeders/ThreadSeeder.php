<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->checkPrerequisites();
        $nbThreads = 30;
        $users = User::all();
        $communities = Community::all();

        foreach ($communities as $community) {
            $threadsPerCommunity = rand(1, 5);
            
            for ($i = 0; $i < $threadsPerCommunity; $i++) {
                $user = $users->random();
                $thread = Thread::factory()->create([
                    'user_id' => $user->id,
                    'community_id' => $community->id,
                ]);
            }
        }

        $createdThreads = Thread::count();
        $remainingThreads = max(0, $nbThreads - $createdThreads);
        
        if ($remainingThreads > 0) {
            for ($i = 0; $i < $remainingThreads; $i++) {
                $user = $users->random();
                $community = $communities->random();
                
                $isRecent = rand(0, 100) < 30; 
                
                if ($isRecent) {
                    $thread = Thread::factory()->recent()->create([
                        'user_id' => $user->id,
                        'community_id' => $community->id,
                    ]);
                } else {
                    $thread = Thread::factory()->create([
                        'user_id' => $user->id,
                        'community_id' => $community->id,
                    ]);
                }
            }
        }
    }
    
    private function checkPrerequisites(): void
    {
        if (User::count() === 0) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez d\'abord exécuter le seeder d\'utilisateurs.');
            exit;
        }
        if (Community::count() === 0) {
            $this->command->error('Aucune communauté trouvée. Veuillez d\'abord exécuter le seeder de communautés.');
            exit;
        }
    }
}
