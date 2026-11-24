<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('training_classes')) {
            return;
        }

        Schema::table('training_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('training_classes', 'program_type')) {
                $table->string('program_type', 30)->default('pelatihan')->after('category');
            }
            if (!Schema::hasColumn('training_classes', 'is_coming_soon')) {
                $table->boolean('is_coming_soon')->default(false)->after('is_active');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('training_classes')) {
            return;
        }

        Schema::table('training_classes', function (Blueprint $table) {
            if (Schema::hasColumn('training_classes', 'is_coming_soon')) {
                $table->dropColumn('is_coming_soon');
            }
            if (Schema::hasColumn('training_classes', 'program_type')) {
                $table->dropColumn('program_type');
            }
        });
    }
};
