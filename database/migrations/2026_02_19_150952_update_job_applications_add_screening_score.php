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
        Schema::table('job_applications', function (Blueprint $table) {
            // Rename ktp_path to transcript_path (lebih relevan dan aman)
            $table->renameColumn('ktp_path', 'transcript_path');
            
            // Auto-screening score fields
            $table->decimal('match_score', 5, 2)->default(0)->after('status')->comment('Overall match percentage (0-100)');
            $table->decimal('education_match', 5, 2)->default(0)->after('match_score')->comment('Education compatibility score');
            $table->decimal('major_match', 5, 2)->default(0)->after('education_match')->comment('Major/field of study match');
            $table->decimal('skill_match', 5, 2)->default(0)->after('major_match')->comment('Skills match score');
            $table->decimal('experience_match', 5, 2)->default(0)->after('skill_match')->comment('Experience match score');
            
            // Screening metadata
            $table->json('screening_details')->nullable()->after('experience_match')->comment('Detailed breakdown of screening');
            $table->timestamp('screened_at')->nullable()->after('screening_details')->comment('When auto-screening was performed');
            
            // Add index for sorting by match score
            $table->index('match_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropIndex(['match_score']);
            
            $table->dropColumn([
                'match_score',
                'education_match',
                'major_match',
                'skill_match',
                'experience_match',
                'screening_details',
                'screened_at',
            ]);
            
            $table->renameColumn('transcript_path', 'ktp_path');
        });
    }
};
