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
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_key'); // e.g., 'visilab-ppr', 'sgm', 'visilab-uji-kesesuaian'
            $table->string('section_key'); // e.g., 'hero', 'features', 'details'
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable(); // Main content text
            $table->json('data')->nullable(); // Flexible JSON data for lists, features, etc.
            $table->string('image_path')->nullable(); // Optional section image
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['page_key', 'section_key']);
            $table->index('is_active');
            $table->index('display_order');
            
            // Unique constraint: one section per position on a page
            $table->unique(['page_key', 'section_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
