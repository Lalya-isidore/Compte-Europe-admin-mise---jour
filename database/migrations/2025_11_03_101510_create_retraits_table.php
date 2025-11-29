<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retraits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('affiliation_id')->constrained('affiliations')->onDelete('cascade');
            $table->decimal('montant', 15, 2);
            $table->enum('operateur', [
                'mtn_benin', 'moov_benin',
                'orange_burkina',
                'mtn_ci', 'moov_ci', 'orange_ci', 'wave_ci',
                'orange_mali',
                'tmoney_togo', 'moov_togo',
                'orange_senegal', 'free_senegal', 'emoney_senegal', 'wave_senegal'
            ]);
            $table->string('numero_telephone', 20);
            $table->enum('statut', ['en_attente', 'en_cours', 'traite', 'annule'])->default('en_attente');
            $table->timestamp('date_demande');
            $table->timestamp('date_traitement')->nullable();
            $table->text('commentaire')->nullable();
            $table->json('details')->nullable(); // Pour stocker des informations supplémentaires
            $table->timestamps();
            
            $table->index(['user_id', 'statut']);
            $table->index(['affiliation_id', 'date_demande']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retraits');
    }
};
