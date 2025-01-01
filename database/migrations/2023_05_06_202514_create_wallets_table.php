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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('points')->default(0);//نقاط مكتسبة in
            $table->integer('expended_points')->default(0);//نقاط مكتسبة out
            $table->integer('casher_points')->default(0);//نقاط مصروفة in
            $table->integer('casher_expended_points')->default(0);//نقاط مصروفة out
            $table->integer('casher_rewards')->default(0);//مكافأت مصروفة in
            $table->integer('casher_expended_rewards')->default(0);//مكافأت مصروفة out
            $table->foreignId('store_id')->on('stores');
            $table->foreignId('user_id')->on('users');
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
