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
        Schema::create('affiliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // L'utilisateur affilié
            $table->foreignId('parrain_id')->nullable()->constrained('users')->onDelete('set null'); // Le parrain
            $table->string('code_affiliation')->unique(); // Code unique d'affiliation
            $table->decimal('commission_rate', 5, 2)->default(10.00); // Taux de commission (%)
            $table->decimal('total_commissions', 10, 2)->default(0); // Total des commissions gagnées
            $table->integer('total_parraines')->default(0); // Nombre de personnes parrainées
            $table->boolean('is_active')->default(true); // Statut actif/inactif
            $table->json('settings')->nullable(); // Paramètres personnalisés
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliations');
    }
};
