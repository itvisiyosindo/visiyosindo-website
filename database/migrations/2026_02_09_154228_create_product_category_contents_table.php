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
        Schema::create('product_category_contents', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->boolean('is_active')->default(false);
            $table->string('slug', 120)->unique();
            $table->index('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_contents');
    }
};
