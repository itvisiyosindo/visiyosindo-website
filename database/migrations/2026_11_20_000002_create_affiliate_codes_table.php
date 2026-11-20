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
        if (!Schema::hasTable('affiliate_codes')) {
            Schema::create('affiliate_codes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('code', 32)->unique();
                $table->unsignedInteger('discount_percent')->default(10);
                $table->unsignedInteger('commission_percent')->default(20);
                $table->unsignedInteger('usage_count')->default(0);
                $table->unsignedBigInteger('total_commission')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_codes');
    }
};
