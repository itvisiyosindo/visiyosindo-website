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
        Schema::table('product_contents', function (Blueprint $table) {
            $table->string('sku', 50)->nullable()->after('brand');
            $table->boolean('is_promo')->default(false)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_contents', function (Blueprint $table) {
            $table->dropColumn(['sku', 'is_promo']);
        });
    }
};
