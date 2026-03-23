<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            Schema::table('mail_history', function (Blueprint $table) {
                $table->timestamp('opened_at')->nullable()->after('status');
                $table->unsignedInteger('open_count')->default(0)->after('opened_at');
            });

            return;
        }

        Schema::table('mail_history', function (Blueprint $table) {
            $table->timestamp('opened_at')->nullable()->after('status');
            $table->unsignedInteger('open_count')->default(0)->after('opened_at');
        });

        DB::statement("ALTER TABLE mail_history MODIFY status ENUM('Envoyé','Livré','Rejeté','Ouvert') DEFAULT 'Envoyé'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            Schema::table('mail_history', function (Blueprint $table) {
                $table->dropColumn(['opened_at', 'open_count']);
            });

            return;
        }

        Schema::table('mail_history', function (Blueprint $table) {
            $table->dropColumn(['opened_at', 'open_count']);
        });

        DB::statement("ALTER TABLE mail_history MODIFY status ENUM('Envoyé','Livré','Rejeté') DEFAULT 'Envoyé'");
    }
};
