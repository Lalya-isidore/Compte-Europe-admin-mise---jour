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
        Schema::table('collected_coupons', function (Blueprint $table) {
            $table->string('amount')->nullable()->after('code');
            $table->string('client_email')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collected_coupons', function (Blueprint $table) {
            $table->dropColumn(['amount', 'client_email']);
        });
    }
};
