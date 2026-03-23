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

        // Ajouter le statut "Envoyé" à l'ENUM
        DB::statement("ALTER TABLE sms_history MODIFY COLUMN status ENUM('Envoyé', 'Livré', 'Rejeté') DEFAULT 'Envoyé'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement("ALTER TABLE sms_history MODIFY COLUMN status ENUM('Livré', 'Rejeté') DEFAULT 'Rejeté'");
    }
};
