<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Admin',
                'role_description' => 'Accès complet à toutes les fonctionnalités de la plateforme, y compris la gestion des utilisateurs, des contenus et des paramètres système',
            ],
            [
                'role_name' => 'Moderateur',
                'role_description' => 'Peut gérer les communautés, approuver/rejeter des posts, bannir temporairement des utilisateurs et traiter les signalements',
            ],
            [
                'role_name' => 'Utilisateur',
                'role_description' => 'Membre standard qui peut créer des posts, commenter, voter et rejoindre des communautés',
            ],
        ];
        Role::upsert($roles, ['role_name'], ['role_description']);
    }
}
