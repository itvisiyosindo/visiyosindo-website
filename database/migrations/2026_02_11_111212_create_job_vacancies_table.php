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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 200)->unique();
            $table->string('department', 100);
            $table->string('location', 150);
            $table->string('type', 50)->default('Full-time'); // Full-time, Part-time, Contract, Internship
            $table->string('experience', 100)->nullable(); // e.g. "2-4 tahun"
            $table->string('education', 150)->nullable(); // e.g. "D3/S1 Teknik Elektro"
            $table->string('salary_range', 100)->nullable(); // optional salary range
            $table->text('description')->nullable(); // HTML deskripsi pekerjaan
            $table->json('responsibilities')->nullable(); // array tanggung jawab
            $table->json('requirements')->nullable(); // array kualifikasi
            $table->json('benefits')->nullable(); // array benefit
            $table->json('skills')->nullable(); // array skills / tags
            $table->string('flyer_image', 255)->nullable(); // flyer gambar lowongan
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->date('deadline')->nullable(); // batas lamaran
            $table->timestamps();

            $table->index(['is_active', 'department']);
            $table->index('deadline');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
