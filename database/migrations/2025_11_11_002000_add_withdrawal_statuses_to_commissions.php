<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        // Ajouter 'en_cours_de_retrait' et 'retiree' au statut de la table commissions
        DB::statement("ALTER TABLE commissions MODIFY COLUMN statut ENUM('en_attente', 'valide', 'paye', 'annule', 'en_cours_de_retrait', 'retiree') DEFAULT 'en_attente'");
    }

    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        // Retirer 'en_cours_de_retrait' et 'retiree'
        DB::statement("ALTER TABLE commissions MODIFY COLUMN statut ENUM('en_attente', 'valide', 'paye', 'annule') DEFAULT 'en_attente'");
    }
};
