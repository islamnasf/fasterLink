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
        Schema::create('package_currencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->on('packages');
            $table->foreignId('currency_id')->on('currencies');
            $table->decimal('basic_price', 10, 2); // Decimal field for basic price
            $table->decimal('multi_branches_price', 10, 2); // Decimal field for multi branches price    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_currencies');
    }
};
