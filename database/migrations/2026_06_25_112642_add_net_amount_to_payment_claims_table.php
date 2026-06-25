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
        Schema::table('payment_claims', function (Blueprint $table) {
            $table->decimal('net_amount', 15, 2)->nullable()->after('amount');
            $table->decimal('commission_rate', 5, 2)->nullable()->after('net_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payment_claims', function (Blueprint $table) {
            $table->dropColumn(['net_amount', 'commission_rate']);
        });
    }
};
