<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->unsignedBigInteger('last_activity')->nullable()->after('auto_deletes_at');
        });
    }

    public function down(): void
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->dropColumn('last_activity');
        });
    }
};
