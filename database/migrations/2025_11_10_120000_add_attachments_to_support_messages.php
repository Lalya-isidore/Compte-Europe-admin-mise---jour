<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('support_messages', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('content');
            $table->string('file_path')->nullable()->after('file_name');
            $table->string('file_type', 120)->nullable()->after('file_path');
            $table->unsignedInteger('file_size')->nullable()->after('file_type');
            $table->string('voice_path')->nullable()->after('file_size');
        });
    }

    public function down(): void
    {
        Schema::table('support_messages', function (Blueprint $table) {
            $table->dropColumn([
                'file_name',
                'file_path',
                'file_type',
                'file_size',
                'voice_path',
            ]);
        });
    }
};
