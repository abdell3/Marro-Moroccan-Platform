<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->checkPrerequisites();
        $this->createPostReports();
        $this->createCommunityReports();
    }
    
    
    private function checkPrerequisites(): void
    {
        if (ReportType::count() === 0) {
            $this->command->info('Aucun type de rapport trouvé. Création de types de rapport...');
            $this->call(ReportTypeSeeder::class);
        }

        if (User::count() === 0) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez d\'abord exécuter le seeder d\'utilisateurs.');
            exit;
        }

        if (Post::count() === 0) {
            $this->command->error('Aucun post trouvé. Veuillez d\'abord exécuter le seeder de posts.');
            exit;
        }
        
        if (Community::count() === 0) {
            $this->command->error('Aucune communauté trouvée. Veuillez d\'abord exécuter le seeder de communautés.');
            exit;
        }
    }
    
    private function createPostReports(): void
    {
        $users = User::inRandomOrder()->limit(10)->get();
        $posts = Post::inRandomOrder()->limit(20)->get();
        
        $reportTypes = ReportType::all();
        $totalReports = rand(15, 30);
        
        $reportCounter = 0;
        foreach ($posts as $post) {
            if ($reportCounter >= $totalReports) break;
        
            $numberOfReports = rand(0, 3);
            
            for ($i = 0; $i < $numberOfReports; $i++) {
                if ($reportCounter >= $totalReports) break;
            
                $reporter = $users->filter(function ($user) use ($post) {
                    return $user->id !== $post->auteur_id;
                })->random();
                
                $reportType = $reportTypes->random();
                
                $isHandled = rand(0, 100) < 40;
                
                $reportData = [
                    'reportable_id' => $post->id,
                    'reportable_type' => Post::class,
                    'user_id' => $reporter->id,
                    'date' => now()->subDays(rand(1, 30)),
                    'raison' => 'Rapport concernant: ' . $post->titre,
                    'type_report_id' => $reportType->id,
                ];
                
                if ($isHandled) {
                    $admin = User::where('id', '!=', $reporter->id)
                                ->inRandomOrder()
                                ->first();
                    
                    $handledDate = now()->subDays(rand(0, 7));
                    $actions = [
                        'Contenu supprimé',
                        'Avertissement envoyé',
                        'Aucune action nécessaire',
                        'Utilisateur sanctionné',
                    ];
                    
                    $reportData = array_merge($reportData, [
                        'handled_at' => $handledDate,
                        'admin_id' => $admin->id,
                        'action_taken' => $actions[array_rand($actions)],
                        'admin_notes' => rand(0, 1) ? 'Notes concernant ce rapport: ' . $this->generateRandomNote() : null,
                    ]);
                }
                    $report = Report::create($reportData);

                if($isHandled) {
                    echo "  - Rapport traité créé pour le post: {$post->titre} (ID: {$post->id})\n";
                } else {
                    echo "  - Rapport non traité créé pour le post: {$post->titre} (ID: {$post->id})\n";
                }
                $reportCounter++;
            }
        }
    }
    
    private function createCommunityReports(): void
    {
        $users = User::inRandomOrder()->limit(10)->get();
        $communities = Community::inRandomOrder()->limit(5)->get();
        $reportTypes = ReportType::all();

        $totalReports = rand(5, 10);

        $reportCounter = 0;
        foreach ($communities as $community) {
            if ($reportCounter >= $totalReports) break;
            $numberOfReports = rand(1, 3);
            
            for ($i = 0; $i < $numberOfReports; $i++) {
                if ($reportCounter >= $totalReports) break;
                $reporter = $users->filter(function ($user) use ($community) {
                    return $user->id !== $community->creator_id;
                })->random();
                $reportType = $reportTypes->random();
                $isHandled = rand(0, 100) < 60;
                
                $reportData = [
                    'reportable_id' => $community->id,
                    'reportable_type' => Community::class,
                    'user_id' => $reporter->id,
                    'date' => now()->subDays(rand(1, 20)),
                    'raison' => 'Rapport concernant la communauté: ' . $community->theme_name,
                    'type_report_id' => $reportType->id,
                ];

                if ($isHandled) {
                    $admin = User::where('id', '!=', $reporter->id)
                                ->inRandomOrder()
                                ->first();
                    
                    $handledDate = now()->subDays(rand(0, 5));
                    $actions = [
                        'Avertissement envoyé',
                        'Aucune action nécessaire',
                        'Communauté mise en surveillance',
                        'Règles mises à jour',
                    ];                    
                    $reportData = array_merge($reportData, [
                        'handled_at' => $handledDate,
                        'admin_id' => $admin->id,
                        'action_taken' => $actions[array_rand($actions)],
                        'admin_notes' => rand(0, 1) ? 'Notes concernant ce rapport: ' . $this->generateRandomNote() : null,
                    ]);                    
                    $report = Report::create($reportData);
                }
                
                if ($isHandled) {
                    echo "  - Rapport traité créé pour la communauté: {$community->theme_name} (ID: {$community->id})\n";
                } else {
                    echo "  - Rapport non traité créé pour la communauté: {$community->theme_name} (ID: {$community->id})\n";
                }
                
                $reportCounter++;
            }
        }
    }

    private function generateRandomNote(): string
    {
        $notes = [
            "Après vérification, ce contenu ne viole pas nos règles communautaires.",
            "L'utilisateur a été averti de ne pas récidiver.",
            "Action prise suite à plusieurs signalements similaires.",
            "Contenu modéré conformément à nos directives.",
            "Demande de clarification envoyée à l'utilisateur.",
            "En attente d'une décision finale après examen approfondi.",
            "Pas d'action nécessaire pour le moment.",
            "À surveiller en cas de récidive."
        ];
        
        return $notes[array_rand($notes)];
    }
}
