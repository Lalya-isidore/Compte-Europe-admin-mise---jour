<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        // Mettre à jour tous les statuts existants
        DB::table('sms_history')
            ->whereIn('status', ['En attente', 'Échec'])
            ->update(['status' => 'Rejeté']);

        // Modifier la colonne pour enlever les anciens statuts
        DB::statement("ALTER TABLE sms_history MODIFY COLUMN status ENUM('Livré', 'Rejeté') DEFAULT 'Rejeté'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE sms_history MODIFY COLUMN status ENUM('En attente', 'Livré', 'Rejeté', 'Échec') DEFAULT 'En attente'");
    }
};
