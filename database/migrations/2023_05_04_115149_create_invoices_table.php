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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->on('users');
            $table->foreignId('country_id')->on('countries');
            $table->foreignId('package_id')->on('packages');
            $table->boolean('multi_branches')->default(0);
            $table->decimal('subtotal');
            $table->decimal('discount');
            $table->decimal('grand_total');
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->default(0);
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
