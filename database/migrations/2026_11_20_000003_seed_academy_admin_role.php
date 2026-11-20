<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('roles')) {
            try {
                $role = Role::firstOrCreate(
                    ['slug' => 'academy_admin'],
                    [
                        'name' => 'Admin Visilab Academy',
                        'description' => 'Pengelola kelas pelatihan, peserta, e-sertifikat, dan program afiliasi Visilab Academy',
                        'is_active' => true,
                    ]
                );

                // Give view-dashboard permission if available
                if (Schema::hasTable('permissions') && Schema::hasTable('role_permissions')) {
                    $dashboardPerm = Permission::where('slug', 'view-dashboard')->first();
                    if ($dashboardPerm && !$role->permissions()->where('id', $dashboardPerm->id)->exists()) {
                        $role->permissions()->attach($dashboardPerm);
                    }
                }
            } catch (\Throwable $e) {
                // Ignore if concurrent or schema not ready
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('roles')) {
            Role::where('slug', 'academy_admin')->delete();
        }
    }
};
