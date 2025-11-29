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
        Schema::table('unlock_codes', function (Blueprint $table) {
            $table->unsignedBigInteger('compte_id')->nullable()->after('id');
            $table->timestamp('expires_at')->nullable()->after('code');
            $table->timestamp('used_at')->nullable()->after('expires_at');
            
            $table->foreign('compte_id')->references('id')->on('comptes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unlock_codes', function (Blueprint $table) {
            $table->dropForeign(['compte_id']);
            $table->dropColumn(['compte_id', 'expires_at', 'used_at']);
        });
    }
};
