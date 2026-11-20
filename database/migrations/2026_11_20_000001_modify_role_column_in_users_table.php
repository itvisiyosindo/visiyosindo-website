<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'student'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('student')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'content_creator', 'digital_marketing', 'hr', 'director') NOT NULL DEFAULT 'content_creator'");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 50)->default('content_creator')->change();
            });
        }
    }
};
