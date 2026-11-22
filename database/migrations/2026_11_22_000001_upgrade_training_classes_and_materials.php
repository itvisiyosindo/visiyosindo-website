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
        if (Schema::hasTable('training_classes')) {
            Schema::table('training_classes', function (Blueprint $table) {
                if (!Schema::hasColumn('training_classes', 'instructor')) {
                    $table->string('instructor')->nullable()->after('batch_name');
                }
                if (!Schema::hasColumn('training_classes', 'location')) {
                    $table->string('location')->nullable()->after('schedule');
                }
                if (!Schema::hasColumn('training_classes', 'delivery_mode')) {
                    $table->string('delivery_mode', 30)->default('online')->after('location');
                }
                if (!Schema::hasColumn('training_classes', 'syllabus')) {
                    $table->longText('syllabus')->nullable()->after('description');
                }
                if (!Schema::hasColumn('training_classes', 'quota')) {
                    $table->unsignedInteger('quota')->nullable()->after('price');
                }
                if (!Schema::hasColumn('training_classes', 'registration_deadline')) {
                    $table->date('registration_deadline')->nullable()->after('quota');
                }
            });
        }

        if (!Schema::hasTable('training_materials')) {
            Schema::create('training_materials', function (Blueprint $table) {
                $table->id();
                $table->foreignId('training_class_id')->constrained('training_classes')->cascadeOnDelete();
                $table->string('title');
                $table->string('type', 20)->default('pdf'); // pdf, video, link
                $table->string('file_path')->nullable();
                $table->string('external_url')->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_materials');

        if (Schema::hasTable('training_classes')) {
            Schema::table('training_classes', function (Blueprint $table) {
                $cols = ['instructor', 'location', 'delivery_mode', 'syllabus', 'quota', 'registration_deadline'];
                foreach ($cols as $col) {
                    if (Schema::hasColumn('training_classes', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
