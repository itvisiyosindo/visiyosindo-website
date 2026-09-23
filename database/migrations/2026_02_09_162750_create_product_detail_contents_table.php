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
        Schema::create('product_detail_contents', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->json('specifications')->nullable();
            $table->json('guarantees')->nullable();
            $table->json('guarantee_terms')->nullable();
            $table->foreignId('product_content_id')->constrained('product_contents')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_detail_contents');
    }
};
