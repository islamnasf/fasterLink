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
        Schema::create('share_points', function (Blueprint $table) {
            $table->id();
            $table->integer('points')->default(0);
            $table->string('code')->unique()->nullable();
            $table->foreignId('user_id')->on('users');
            $table->foreignId('store_id')->on('stores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_points');
    }
};
