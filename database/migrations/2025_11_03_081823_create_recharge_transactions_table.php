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
        Schema::create('recharge_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('compte_id')->nullable()->constrained()->onDelete('set null');
            $table->string('transaction_id')->unique(); // ID unique de la transaction
            $table->decimal('amount', 15, 2); // Montant en F CFA
            $table->integer('credits_earned')->default(0); // Crédits gagnés
            $table->enum('payment_method', ['fedapay', 'oosic', 'card', 'mobile_money', 'bank_transfer']);
            $table->string('payment_provider')->nullable(); // Orange Money, Wave, etc.
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->string('external_transaction_id')->nullable(); // ID de la transaction chez le fournisseur
            $table->json('payment_details')->nullable(); // Détails du paiement
            $table->json('response_data')->nullable(); // Réponse complète de l'API
            $table->string('failure_reason')->nullable(); // Raison de l'échec
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Index pour les recherches fréquentes
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharge_transactions');
    }
};
