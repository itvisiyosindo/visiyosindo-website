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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Testimonial giver name
            $table->string('position')->nullable(); // Their position/role
            $table->string('company')->nullable(); // Their company/institution
            $table->text('content'); // Testimonial content/message
            $table->string('avatar_path')->nullable(); // Avatar image
            $table->integer('rating')->default(5); // Star rating (1-5)
            $table->string('page_key')->default('visilab-ppr'); // Which page to display on
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('page_key');
            $table->index('is_active');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
