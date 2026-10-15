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
        Schema::create('sgm_page', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_title');
            $table->text('hero_subtitle');
            
            // Company Info
            $table->string('company_name');
            $table->integer('founded_year');
            $table->text('company_description');
            $table->text('about_text');
            
            // Vision & Mission
            $table->text('vision_text');
            $table->json('mission_items'); // Array of mission statements
            
            // Info Cards (Terpercaya, Inovatif, etc)
            $table->json('info_cards');
            
            // Services/Sertifikasi (6 services)
            $table->string('services_title')->default('Sertifikat Kami');
            $table->text('services_subtitle')->nullable();
            $table->json('services'); // Array of service objects
            
            // Parent Company Relationship
            $table->string('parent_company_name')->default('PT Visi Yosindo Medikal');
            $table->text('parent_company_description');
            $table->json('benefits'); // Array of benefits
            
            // CTA Section
            $table->string('cta_title')->default('Tertarik Bekerja Sama?');
            $table->text('cta_subtitle');
            $table->string('whatsapp_number')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sgm_page');
    }
};
