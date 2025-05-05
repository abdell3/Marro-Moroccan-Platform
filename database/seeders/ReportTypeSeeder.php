<?php

namespace Database\Seeders;

use App\Models\ReportType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ReportType::count() > 0) {
            $this->command->info('Les types de rapport existent déjà. Aucun besoin de les recréer.');
            return;
        }
 
        $reportTypes = [
            [
                'name' => 'Contenu inapproprié',
                'description' => 'Contenu qui ne respecte pas les règles de la communauté',
            ],
            [
                'name' => 'Harcèlement',
                'description' => 'Comportement agressif ou hostile envers un utilisateur',
            ],
            [
                'name' => 'Spam',
                'description' => 'Contenu commercial non-sollicité ou répétitif',
            ],
            [
                'name' => 'Information erronée',
                'description' => 'Partage délibéré d\'informations fausses ou trompeuses',
            ],
            [
                'name' => 'Contenu offensant',
                'description' => 'Contenu qui peut offenser certains groupes (racisme, sexisme, etc.)',
            ],
            [
                'name' => 'Violation des droits d\'auteur',
                'description' => 'Utilisation de contenu protégé sans autorisation',
            ],
            [
                'name' => 'Violence',
                'description' => 'Incitation à la violence, menaces ou contenu graphique violent',
            ],
            [
                'name' => 'Autre',
                'description' => 'Autres raisons ne correspondant pas aux catégories existantes',
            ],
        ];
        
        foreach ($reportTypes as $type) {
            ReportType::create($type);
            echo "  - Type de rapport créé: {$type['name']}\n";
        }
        
        $this->command->info('Types de rapport créés avec succès!');
    }
}
