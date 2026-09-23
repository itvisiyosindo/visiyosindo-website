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
            $table->string('recommendation', 50)->default('not_recommended')->after('experience_match')
                ->comment('AI recommendation level: highly_recommended, recommended, consider, not_recommended');
            
            $table->index('recommendation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropIndex(['recommendation']);
            $table->dropColumn('recommendation');
        });
    }
};
