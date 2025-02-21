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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->foreignId('city_id')->on('cities');
            $table->string('location')->nullable();
            $table->string('address_en')->nullable();
            $table->string('address_ar')->nullable();
            $table->boolean('is_main')->default(0);
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
        Schema::dropIfExists('branches');
    }
};
