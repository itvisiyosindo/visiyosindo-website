<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, seed RBAC system (roles and permissions)
        $this->call([RbacSeeder::class, SgmPageSeeder::class, VisilabPageSeeder::class]);

        // Create Admin User and assign admin role
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@visiyosindo.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);
        $admin->assignRole(Role::where('slug', 'admin')->first());

        // Create Director User and assign director role
        $director = User::create([
            'name' => 'John Director',
            'email' => 'director@visiyosindo.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DIRECTOR,
            'is_active' => true,
        ]);
        $director->assignRole(Role::where('slug', 'director')->first());

        // Create Content Creator User and assign content-creator role
        $creator = User::create([
            'name' => 'Sarah Content',
            'email' => 'content@visiyosindo.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CONTENT_CREATOR,
            'is_active' => true,
        ]);
        $creator->assignRole(Role::where('slug', 'content-creator')->first());

        // Create Digital Marketing User and assign marketing-manager role
        $marketing = User::create([
            'name' => 'Mike Marketing',
            'email' => 'marketing@visiyosindo.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DIGITAL_MARKETING,
            'is_active' => true,
        ]);
        $marketing->assignRole(Role::where('slug', 'marketing-manager')->first());

        // Create HR User and assign hr-manager role
        $hr = User::create([
            'name' => 'Emma HR',
            'email' => 'hr@visiyosindo.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_HR,
            'is_active' => true,
        ]);
        $hr->assignRole(Role::where('slug', 'hr-manager')->first());

        // Create Inactive User (for testing)
        $inactive = User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@visiyosindo.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_CONTENT_CREATOR,
            'is_active' => false,
        ]);
        $inactive->assignRole(Role::where('slug', 'content-creator')->first());

        $this->command->info('Database seeded successfully!');
    }
}
