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
        Schema::create('mail_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('expediteur'); // Nom de l'expéditeur
            $table->string('destinataire'); // Email du destinataire
            $table->string('objet'); // Objet de l'email
            $table->text('contenu'); // Contenu HTML de l'email
            $table->string('adresse_reponse')->nullable(); // Email de réponse (facultatif)
            $table->string('fichier_joint')->nullable(); // Chemin du fichier joint
            $table->integer('credits_used')->default(0);
            $table->enum('status', ['Envoyé', 'Livré', 'Rejeté'])->default('Envoyé');
            $table->string('message_id')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_history');
    }
};
