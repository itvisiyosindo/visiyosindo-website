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
        Schema::create('product_installations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('product_name')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('location')->nullable();
            $table->date('installation_date')->nullable();
            $table->text('description')->nullable();
            $table->string('image');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_installations');
    }
};
