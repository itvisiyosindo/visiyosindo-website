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
        Schema::create('map_markers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of location (e.g., "RS Advent Medan")
            $table->string('city'); // City name (e.g., "Medan, Sumatera Utara")
            $table->enum('type', ['hospital', 'clinic', 'lab'])->default('hospital'); // Marker type
            $table->decimal('latitude', 10, 7); // Latitude coordinate
            $table->decimal('longitude', 10, 7); // Longitude coordinate
            $table->text('description')->nullable(); // Optional description
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('type');
            $table->index('is_active');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('map_markers');
    }
};
