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
        // Create roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->index('slug');
            $table->index('created_at');
        });

        // Create permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('category', 50)->default('general')->index('permissions_category_idx');
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
            $table->index('slug');
            $table->index('created_at');
        });

        // Create role_permissions pivot table
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['role_id', 'permission_id']);
            $table->index('role_id');
            $table->index('permission_id');
        });

        // Create user_roles pivot table
        Schema::create('user_roles', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['user_id', 'role_id']);
            $table->index('user_id');
            $table->index('role_id');
        });

        // Create user_permissions pivot table
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['user_id', 'permission_id']);
            $table->index('user_id');
            $table->index('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
