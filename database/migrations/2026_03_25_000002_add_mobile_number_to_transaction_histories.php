<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaction_histories', 'mobile_number')) {
            Schema::table('transaction_histories', function (Blueprint $table) {
                $table->string('mobile_number')->nullable()->after('transfer_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transaction_histories', 'mobile_number')) {
            Schema::table('transaction_histories', function (Blueprint $table) {
                $table->dropColumn('mobile_number');
            });
        }
    }
};
