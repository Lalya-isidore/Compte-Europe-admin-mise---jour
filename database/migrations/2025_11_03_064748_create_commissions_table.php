<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affiliation_id')->constrained()->onDelete('cascade');
            $table->foreignId('parraine_user_id')->constrained('users')->onDelete('cascade'); // Utilisateur parrainé
            $table->foreignId('compte_id')->nullable()->constrained()->onDelete('cascade'); // Compte créé
            $table->string('action_type'); // Type d'action: 'inscription', 'premier_compte', 'virement', etc.
            $table->decimal('montant_base', 10, 2)->default(0); // Montant de base de l'action
            $table->decimal('taux_commission', 5, 2); // Taux appliqué
            $table->decimal('montant_commission', 10, 2); // Commission calculée
            $table->enum('statut', ['en_attente', 'valide', 'paye', 'annule'])->default('en_attente');
            $table->timestamp('date_action'); // Date de l'action génératrice
            $table->timestamp('date_validation')->nullable(); // Date de validation
            $table->json('details')->nullable(); // Détails supplémentaires
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
