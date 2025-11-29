<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Affiliation;

class AffiliationTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur test qui servira de parrain
        $parrain = User::firstOrCreate(
            ['email' => 'parrain@test.com'],
            [
                'nom' => 'Parrain',
                'prenom' => 'Test',
                'password' => Hash::make('password123'),
                'credit_user' => 0,
            ]
        );

        // Créer l'affiliation pour ce parrain s'il n'en a pas
        $affiliation = $parrain->affiliation;
        if (!$affiliation) {
            $affiliation = new Affiliation();
            $affiliation->user_id = $parrain->id;
            $affiliation->code_affiliation = $affiliation->generateCodeAffiliation();
            $affiliation->commission_rate = 10.00;
            $affiliation->save();
        }

        echo "Utilisateur parrain créé: \n";
        echo "Email: parrain@test.com\n";
        echo "Password: password123\n";
        echo "Code d'affiliation: {$affiliation->code_affiliation}\n";
    }
}