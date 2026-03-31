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
        Schema::create('iban_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type', 10); // iban or cb
            $table->string('number_masked', 50);
            $table->boolean('is_valid')->default(false);
            $table->string('country')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bic_code', 20)->nullable();
            $table->string('card_brand', 30)->nullable();
            $table->string('card_type', 30)->nullable();
            $table->json('lookup_data')->nullable();
            $table->unsignedInteger('credits_used')->default(0);
            $table->string('error_message')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iban_verifications');
    }
};
