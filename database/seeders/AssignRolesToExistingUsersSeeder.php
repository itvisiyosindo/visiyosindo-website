<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignRolesToExistingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Map email to role slug
        $userRoleMap = [
            'admin@visiyosindo.com' => 'admin',
            'director@visiyosindo.com' => 'director',
            'content@visiyosindo.com' => 'content-creator',
            'marketing@visiyosindo.com' => 'marketing-manager',
            'hr@visiyosindo.com' => 'hr-manager',
            'inactive@visiyosindo.com' => 'content-creator',
        ];

        foreach ($userRoleMap as $email => $roleSlug) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $role = Role::where('slug', $roleSlug)->first();
                if ($role && !$user->roles()->where('role_id', $role->id)->exists()) {
                    $user->assignRole($role);
                    $this->command->line("✓ Assigned role '$roleSlug' to user '$email'");
                }
            }
        }

        $this->command->info('User roles assigned successfully!');
    }
}
