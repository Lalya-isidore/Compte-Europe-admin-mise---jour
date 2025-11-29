<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAutoDeletesAtToComptesTable extends Migration
{
    public function up()
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->timestamp('auto_deletes_at')->nullable()->index();
            // Optionnel : ajouter un flag pour identifier les comptes auto-crées
            $table->boolean('is_auto_created')->default(false)->index();
        });
    }

    public function down()
    {
        Schema::table('comptes', function (Blueprint $table) {
            $table->dropColumn(['auto_deletes_at', 'is_auto_created']);
        });
    }
}
