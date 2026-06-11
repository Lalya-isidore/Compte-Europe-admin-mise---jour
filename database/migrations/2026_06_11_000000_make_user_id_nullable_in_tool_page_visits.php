<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tool_page_visits', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
            $table->string('session_id', 40)->nullable()->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('tool_page_visits', function (Blueprint $table) {
            $table->dropColumn('session_id');
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};
