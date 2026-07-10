<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sms_history', function (Blueprint $table) {
            $table->boolean('dispatched')->default(false)->after('error_message');
            $table->string('rejection_reason')->nullable()->after('dispatched');
        });
    }

    public function down(): void
    {
        Schema::table('sms_history', function (Blueprint $table) {
            $table->dropColumn(['dispatched', 'rejection_reason']);
        });
    }
};
