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
        Schema::table('users', function (Blueprint $table) {
            $table->string('code_parrainage')->nullable()->after('credit_user'); // Code utilisé pour être parrainé
            $table->foreignId('parrain_id')->nullable()->after('code_parrainage')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parrain_id']);
            $table->dropColumn(['code_parrainage', 'parrain_id']);
        });
    }
};
