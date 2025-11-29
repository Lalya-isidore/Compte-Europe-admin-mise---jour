<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('transaction_histories', 'compte_id')) {
            Schema::table('transaction_histories', function (Blueprint $table) {
                $table->unsignedBigInteger('compte_id')->nullable()->after('user_id')->index();
                // Optionally add foreign key if desired:
                // $table->foreign('compte_id')->references('id')->on('comptes')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('transaction_histories', 'compte_id')) {
            Schema::table('transaction_histories', function (Blueprint $table) {
                // If you added a foreign key, drop it first
                // $table->dropForeign(['compte_id']);
                $table->dropColumn('compte_id');
            });
        }
    }
};
