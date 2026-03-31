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
        Schema::create('phone_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone_number', 30);
            $table->boolean('is_valid')->default(false);
            $table->string('country_name')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('network_name')->nullable();
            $table->string('network_type', 20)->nullable();
            $table->boolean('is_reachable')->default(false);
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
        Schema::dropIfExists('phone_verifications');
    }
};
