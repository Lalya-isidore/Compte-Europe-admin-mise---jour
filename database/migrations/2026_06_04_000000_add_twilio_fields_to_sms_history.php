<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sms_history', function (Blueprint $table) {
            $table->string('twilio_sid', 64)->nullable()->after('message_id');
            $table->string('delivery_status', 32)->nullable()->after('twilio_sid');
            $table->string('error_code', 16)->nullable()->after('delivery_status');
            $table->boolean('fallback_sent')->default(false)->after('error_code');
            $table->string('fallback_sid', 64)->nullable()->after('fallback_sent');

            $table->index('twilio_sid');
            $table->index('fallback_sid');
        });
    }

    public function down(): void
    {
        Schema::table('sms_history', function (Blueprint $table) {
            $table->dropColumn(['twilio_sid','delivery_status','error_code','fallback_sent','fallback_sid']);
        });
    }
};
