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
        Schema::create('sms_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('expediteur', 11);
            $table->string('pays', 10);
            $table->string('destinataire', 20);
            $table->text('message');
            $table->integer('sms_count')->default(1);
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
        Schema::dropIfExists('sms_history');
    }
};
