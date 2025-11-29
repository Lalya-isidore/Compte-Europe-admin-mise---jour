<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompteIdToTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('transfers')) {
            return;
        }

        Schema::table('transfers', function (Blueprint $table) {
            // nullable for safety; we'll backfill then optionally add FK later
            $table->unsignedBigInteger('compte_id')->nullable()->after('id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (! Schema::hasTable('transfers')) {
            return;
        }

        Schema::table('transfers', function (Blueprint $table) {
            if (Schema::hasColumn('transfers', 'compte_id')) {
                $table->dropIndex(['compte_id']);
                $table->dropColumn('compte_id');
            }
        });
    }
}
