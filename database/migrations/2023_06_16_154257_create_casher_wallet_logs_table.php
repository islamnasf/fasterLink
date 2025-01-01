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
        Schema::create('casher_wallet_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('points');
            $table->integer('previous_points')->default(0);
            $table->string('type');
            $table->string('points_source')->nullable();
            $table->foreignId('store_id')->on('stores');
            $table->foreignId('user_id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casher_wallet_logs');
    }
};
