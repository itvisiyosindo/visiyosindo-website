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
        Schema::table('home_introductions', function (Blueprint $table) {
            $table->json('features')->nullable()->after('description');
            $table->string('video_url')->nullable()->after('image_path');
            $table->string('additional_image_1')->nullable()->after('video_url');
            $table->string('additional_image_2')->nullable()->after('additional_image_1');
            $table->string('additional_image_3')->nullable()->after('additional_image_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_introductions', function (Blueprint $table) {
            $table->dropColumn(['features', 'video_url', 'additional_image_1', 'additional_image_2', 'additional_image_3']);
        });
    }
};
