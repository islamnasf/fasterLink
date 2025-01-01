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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('username')->unique()->nullable();
            $table->foreignId('category_id')->on('categories');
            $table->foreignId('city_id')->on('cities');
            $table->foreignId('user_id')->on('users');
            $table->foreignId('package_id')->on('packages');
            $table->text('full_description_en')->nullable();
            $table->text('full_description_ar')->nullable();    
            $table->text('logo')->nullable();
            $table->string('cover_type')->nullable();
            $table->text('cover_images')->nullable();
            $table->text('cover_video_url')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('multi_branches');
            $table->boolean('network')->default(0);

            $table->string('default_page')->nullable();
            $table->string('products_show_method')->nullable();
            $table->string('identity_color')->nullable();
            $table->boolean('ratings_active')->default(1);
            $table->boolean('views_active')->default(1);
            
            $table->text('effect_button')->nullable();
            $table->text('introduction_screen')->nullable();
            $table->text('ad_bar')->nullable();
            $table->text('background_image')->nullable();

            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
