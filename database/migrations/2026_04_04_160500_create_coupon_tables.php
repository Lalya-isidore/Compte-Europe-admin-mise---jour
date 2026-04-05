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
        Schema::create('coupon_collections', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('user_id')->constrained()->onDelete('cascade');
            $blueprint->string('kind'); // PCS, Neosurf, etc.
            $blueprint->string('lang', 10);
            $blueprint->unsignedTinyInteger('count')->default(1); // Nombre de coupons à collecter
            $blueprint->string('token', 64)->unique();
            $blueprint->string('status')->default('active'); // active, completed
            $blueprint->integer('cost')->default(2000);
            $blueprint->timestamps();
        });

        Schema::create('collected_coupons', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('collection_id')->constrained('coupon_collections')->onDelete('cascade');
            $blueprint->string('code');
            $blueprint->string('status')->default('pending');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collected_coupons');
        Schema::dropIfExists('coupon_collections');
    }
};
