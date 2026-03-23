<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('url_shortener_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('original_url');
            $table->string('short_url')->unique();
            $table->string('provider')->default('is.gd');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('url_shortener_history');
    }
};
