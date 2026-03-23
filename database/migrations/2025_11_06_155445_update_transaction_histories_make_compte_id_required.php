<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

            // Supprimer la contrainte FK existante si elle existe (via information_schema)
            $database = env('DB_DATABASE') ?: DB::getDatabaseName();
            $fk = DB::selectOne(
                'SELECT CONSTRAINT_NAME as name FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1',
                [$database, 'transaction_histories', 'compte_id']
            );
            if ($fk && isset($fk->name)) {
                DB::statement("ALTER TABLE `transaction_histories` DROP FOREIGN KEY `{$fk->name}`");
            }

            Schema::table('transaction_histories', function (Blueprint $table) {
                // Mettre à jour les transactions existantes qui n'ont pas de compte_id
                DB::statement('
                    UPDATE transaction_histories th
                    LEFT JOIN comptes c ON th.user_id = c.user_id
                    SET th.compte_id = c.id
                    WHERE th.compte_id IS NULL AND c.id IS NOT NULL
                ');

                // Rendre la colonne non nullable après avoir mis à jour les données existantes
                $table->foreignId('compte_id')->nullable(false)->change();

                // Recréer la contrainte de clé étrangère avec RESTRICT au lieu de SET NULL
                $table->foreign('compte_id')
                    ->references('id')
                    ->on('comptes')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        // Supprimer la contrainte FK RESTRICT si elle existe
        $database = env('DB_DATABASE') ?: DB::getDatabaseName();
        $fk = DB::selectOne(
            'SELECT CONSTRAINT_NAME as name FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1',
            [$database, 'transaction_histories', 'compte_id']
        );
        if ($fk && isset($fk->name)) {
            DB::statement("ALTER TABLE `transaction_histories` DROP FOREIGN KEY `{$fk->name}`");
        }

        Schema::table('transaction_histories', function (Blueprint $table) {
            // Rendre la colonne nullable à nouveau
            $table->foreignId('compte_id')->nullable()->change();

            // Recréer la contrainte originale avec SET NULL
            $table->foreign('compte_id')
                ->references('id')
                ->on('comptes')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }
};
