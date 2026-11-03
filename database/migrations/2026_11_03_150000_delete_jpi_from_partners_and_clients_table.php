<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('partners')) {
            DB::table('partners')
                ->where('name', 'like', '%jpi%')
                ->orWhere('name', 'like', '%JPI%')
                ->delete();
        }

        if (Schema::hasTable('clients')) {
            DB::table('clients')
                ->where('name', 'like', '%jpi%')
                ->orWhere('name', 'like', '%JPI%')
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
