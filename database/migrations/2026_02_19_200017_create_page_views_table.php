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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500);
            $table->string('path', 255)->index();
            $table->string('method', 10)->default('GET');
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type', 50)->nullable(); // mobile, tablet, desktop
            $table->string('browser', 100)->nullable();
            $table->string('platform', 100)->nullable(); // OS
            $table->ipAddress('ip_address')->nullable();
            $table->string('country', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('referer', 500)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id', 100)->index();
            $table->boolean('is_bot')->default(false);
            $table->integer('duration')->nullable(); // seconds on page
            $table->timestamps();

            $table->index(['created_at', 'path']);
            $table->index(['country', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
