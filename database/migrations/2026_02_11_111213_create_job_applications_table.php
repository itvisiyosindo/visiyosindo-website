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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_vacancy_id')->constrained('job_vacancies')->cascadeOnDelete();

            // Step 1: Data Diri
            $table->string('full_name', 150);
            $table->string('email', 150);
            $table->string('phone', 30);
            $table->date('birth_date');
            $table->text('address');

            // Step 2: Pendidikan & Pengalaman
            $table->string('education', 100); // SMA, D3, S1, S2, S3
            $table->string('major', 150); // jurusan
            $table->string('institution', 200); // universitas/sekolah
            $table->string('graduation_year', 10);
            $table->text('work_experience')->nullable();
            $table->string('last_job', 200)->nullable();

            // Step 3: Dokumen
            $table->string('cv_path', 255);
            $table->string('ktp_path', 255);
            $table->string('ijazah_path', 255)->nullable();

            // Status tracking
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->text('notes')->nullable(); // catatan internal HR

            $table->timestamps();

            $table->index(['job_vacancy_id', 'status']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
