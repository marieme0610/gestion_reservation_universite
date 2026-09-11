<?php

use App\Model\Utilisateur;

return new class {
    public function run(): void
    {
        Utilisateur::updateOrCreate(
            ['email' => 'admin@universite.fr'],
            [
                'nom' => 'Administrateur',
                'mot_de_passe' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ]
        );

        Utilisateur::updateOrCreate(
            ['email' => 'responsable@universite.fr'],
            [
                'nom' => 'Marieme',
                'mot_de_passe' => password_hash('respo123', PASSWORD_DEFAULT),
                'role' => 'responsable',
            ]
        );

        echo "  UtilisateurSeeder : comptes de test créés.\n";
    }
};
