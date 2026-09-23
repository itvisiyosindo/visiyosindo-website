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
        Schema::create('visilab_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // uji-kalibrasi, uji-paparan, uji-kesesuaian, ppr
            $table->string('name'); // Display name
            
            // Hero Section
            $table->string('hero_title');
            $table->text('hero_description');
            
            // Introduction Section 
            $table->string('intro_title');
            $table->text('intro_description');
            $table->json('intro_images')->nullable(); // 4 images with captions
            
            // Services/Features Section
            $table->string('services_title')->nullable();
            $table->json('services_content')->nullable(); // Array of service cards
            
            // Process Flow Section
            $table->string('process_title')->nullable();
            $table->json('process_steps')->nullable(); // Array of process steps
            
            // CTA Section
            $table->string('cta_title');
            $table->text('cta_description')->nullable();
            
            // Additional Content (flexible)
            $table->json('additional_data')->nullable();
            
            // Meta & Status
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visilab_pages');
    }
};
