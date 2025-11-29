<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransferIdToTransactionHistoriesTable extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('transaction_histories')) {
            return;
        }

        Schema::table('transaction_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('transaction_histories', 'transfer_id')) {
                $table->unsignedBigInteger('transfer_id')->nullable()->after('description');
                $table->index('transfer_id', 'idx_transaction_transfer_id');
            }
        });
    }

    public function down()
    {
        if (! Schema::hasTable('transaction_histories')) {
            return;
        }

        Schema::table('transaction_histories', function (Blueprint $table) {
            if (Schema::hasColumn('transaction_histories', 'transfer_id')) {
                $table->dropIndex('idx_transaction_transfer_id');
                $table->dropColumn('transfer_id');
            }
        });
    }
}
