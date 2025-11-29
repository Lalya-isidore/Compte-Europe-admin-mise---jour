<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier la colonne operateur pour ajouter les nouveaux opérateurs
        Schema::table('retraits', function (Blueprint $table) {
            // Drop the old enum column and recreate with new values
            $table->dropColumn('operateur');
        });

        Schema::table('retraits', function (Blueprint $table) {
            $table->enum('operateur', [
                'mtn_benin', 'moov_benin',
                'orange_burkina',
                'mtn_ci', 'moov_ci', 'orange_ci', 'wave_ci',
                'orange_mali',
                'tmoney_togo', 'moov_togo',
                'orange_senegal', 'free_senegal', 'emoney_senegal', 'wave_senegal'
            ])->after('montant');
            
            // Augmenter la taille du champ numero_telephone pour inclure l'indicatif
            $table->string('numero_telephone', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('retraits', function (Blueprint $table) {
            $table->dropColumn('operateur');
        });

        Schema::table('retraits', function (Blueprint $table) {
            $table->enum('operateur', ['orange', 'mtn', 'moov'])->after('montant');
            $table->string('numero_telephone', 15)->change();
        });
    }
};
