<?php

namespace Database\Factories;

use App\Models\ReportType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportType>
 */
class ReportTypeFactory extends Factory
{

    protected $model = ReportType::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reportTypes = [
            'Contenu inapproprié' => 'Contenu qui ne respecte pas les règles de la communauté',
            'Harcèlement' => 'Comportement agressif ou hostile envers un utilisateur',
            'Spam' => 'Contenu commercial non-sollicité ou répétitif',
            'Information erronée' => 'Partage délibéré d\'informations fausses',
            'Contenu offensant' => 'Contenu qui peut offenser certains groupes',
            'Violation des droits d\'auteur' => 'Utilisation de contenu protégé sans autorisation',
            'Violence' => 'Incitation à la violence ou menaces',
            'Autre' => 'Autres raisons ne correspondant pas aux catégories existantes'
        ];
        
        $name = $this->faker->unique()->randomElement(array_keys($reportTypes));
        $description = $reportTypes[$name];
        return [
            'name' => $name,
            'description' => $description,
        ];
    }
}
