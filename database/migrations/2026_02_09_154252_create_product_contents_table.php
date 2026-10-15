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
        Schema::create('product_contents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 150)->unique();
            $table->string('brand', 100);
            $table->string('thumbnail', 255)->nullable();
            $table->boolean('is_active')->default(false);

            $table->string('akl_link', 255)->nullable();
            $table->string('brochure_link', 255)->nullable();
            $table->string('ecatalog_link', 255)->nullable();

            $table->text('short_description')->nullable();
            $table->json('features')->nullable();
            $table->json('yt_video_links')->nullable();

            $table->foreignId('product_category_content_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index(['is_active', 'product_category_content_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_contents');
    }
};
