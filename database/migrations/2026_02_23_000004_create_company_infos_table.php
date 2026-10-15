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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            
            // History Section
            $table->string('history_title')->default('Perjalanan Kami Membangun Kepercayaan');
            $table->text('history_content')->nullable();
            $table->integer('history_stat_years')->default(13);
            $table->integer('history_stat_clients')->default(500);
            $table->integer('history_stat_professionals')->default(100);
            
            // Vision Section
            $table->string('vision_title')->default('Visi Kami');
            $table->text('vision_content')->nullable();
            
            // Mission Section
            $table->string('mission_title')->default('Misi Kami');
            $table->json('mission_items')->nullable(); // Array of mission statements
            
            // Values Section
            $table->string('values_title')->default('Nilai-Nilai Kami');
            $table->json('values_items')->nullable(); // Array of {title, description, icon} objects
            
            // National Coverage Section
            $table->string('coverage_title')->default('Persebaran Customer Kami');
            $table->text('coverage_description')->nullable();
            $table->integer('coverage_stat_provinces')->default(34);
            $table->integer('coverage_stat_hospitals')->default(500);
            $table->integer('coverage_stat_clinics')->default(1000);
            $table->integer('coverage_stat_cities')->default(100);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
