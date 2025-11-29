<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompteIdInferredToTransfersTable extends Migration
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
            if (! Schema::hasColumn('transfers', 'compte_id_inferred')) {
                $table->boolean('compte_id_inferred')->default(true)->after('compte_id')->index();
            }
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
            if (Schema::hasColumn('transfers', 'compte_id_inferred')) {
                $table->dropIndex(['compte_id_inferred']);
                $table->dropColumn('compte_id_inferred');
            }
        });
    }
}
