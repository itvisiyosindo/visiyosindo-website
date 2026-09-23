<?php

namespace Database\Seeders;

use App\Constants\Permission as PermissionConstants;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Role::query()->delete();
        Permission::query()->delete();

        // Create all permissions
        $this->createPermissions();

        // Create all roles
        $this->createRoles();

        $this->command->info('RBAC system seeded successfully!');
    }

    /**
     * Create all permissions and assign them to categories
     */
    private function createPermissions(): void
    {
        $allPermissions = PermissionConstants::getAll();

        foreach ($allPermissions as $category => $permissions) {
            foreach ($permissions as $slug => $name) {
                Permission::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $name,
                        'description' => "Permission to $name in $category module",
                        'category' => $category,
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->line("  ✓ Created " . Permission::count() . " permissions");
    }

    /**
     * Create roles and assign permissions to them
     */
    private function createRoles(): void
    {
        // Admin Role - Has ALL permissions
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'description' => 'Full system access - can manage all content and users',
                'is_active' => true,
            ]
        );

        // Get all permission slugs
        $allPermissions = Permission::pluck('id', 'slug')->toArray();
        $adminRole->permissions()->sync(array_values($allPermissions));
        $this->command->line("  ✓ Created Admin role with " . count($allPermissions) . " permissions");

        // Director Role - View most things, approve and publish content
        $directorRole = Role::firstOrCreate(
            ['slug' => 'director'],
            [
                'name' => 'Director',
                'description' => 'Can view contents, approve/publish, and access analytics',
                'is_active' => true,
            ]
        );

        $directorPermissions = [
            // Dashboard
            PermissionConstants::DASHBOARD_VIEW,
            // Products - View only
            PermissionConstants::PRODUCT_VIEW,
            PermissionConstants::PRODUCT_CATEGORY_VIEW,
            // Careers
            PermissionConstants::CAREER_VIEW,
            PermissionConstants::CAREER_PUBLISH,
            PermissionConstants::APPLICANT_VIEW,
            PermissionConstants::APPLICANT_SHORTLIST,
            // News
            PermissionConstants::NEWS_VIEW,
            PermissionConstants::NEWS_PUBLISH,
            // Galleries
            PermissionConstants::GALLERY_VIEW,
            PermissionConstants::GALLERY_CATEGORY_VIEW,
            // Certificates
            PermissionConstants::CERTIFICATE_VIEW,
            PermissionConstants::CERTIFICATE_CATEGORY_VIEW,
            // Company
            PermissionConstants::TEAM_VIEW,
            PermissionConstants::TESTIMONIAL_VIEW,
            PermissionConstants::PARTNER_VIEW,
            PermissionConstants::COMPANY_INFO_VIEW,
            PermissionConstants::VISION_MISSION_VIEW,
            PermissionConstants::DIRECTOR_MESSAGE_VIEW,
            // Website
            PermissionConstants::HERO_SLIDE_VIEW,
            PermissionConstants::PROMO_BANNER_VIEW,
            PermissionConstants::HOME_INTRO_VIEW,
            PermissionConstants::OFFICE_LOCATION_VIEW,
            PermissionConstants::MAP_MARKER_VIEW,
            PermissionConstants::VISILAB_PAGE_VIEW,
            PermissionConstants::SGM_PAGE_VIEW,
            // Support
            PermissionConstants::CONTACT_SUBMISSION_VIEW,
            PermissionConstants::CONTACT_SUBMISSION_RESPOND,
            // Admin
            PermissionConstants::ANALYTICS_VIEW,
            PermissionConstants::USER_VIEW,
        ];

        $directorPermissionIds = Permission::whereIn('slug', $directorPermissions)
            ->pluck('id')
            ->toArray();
        $directorRole->permissions()->sync($directorPermissionIds);
        $this->command->line("  ✓ Created Director role with " . count($directorPermissionIds) . " permissions");

        // Content Creator Role - Create and edit content
        $creatorRole = Role::firstOrCreate(
            ['slug' => 'content-creator'],
            [
                'name' => 'Content Creator',
                'description' => 'Can create, edit and delete content (news, galleries, products)',
                'is_active' => true,
            ]
        );

        $creatorPermissions = [
            PermissionConstants::DASHBOARD_VIEW,
            // Products
            PermissionConstants::PRODUCT_VIEW,
            PermissionConstants::PRODUCT_CREATE,
            PermissionConstants::PRODUCT_EDIT,
            PermissionConstants::PRODUCT_DELETE,
            PermissionConstants::PRODUCT_CATEGORY_VIEW,
            // News
            PermissionConstants::NEWS_VIEW,
            PermissionConstants::NEWS_CREATE,
            PermissionConstants::NEWS_EDIT,
            PermissionConstants::NEWS_DELETE,
            // Galleries
            PermissionConstants::GALLERY_VIEW,
            PermissionConstants::GALLERY_CREATE,
            PermissionConstants::GALLERY_EDIT,
            PermissionConstants::GALLERY_DELETE,
            PermissionConstants::GALLERY_CATEGORY_VIEW,
            PermissionConstants::GALLERY_CATEGORY_CREATE,
            PermissionConstants::GALLERY_CATEGORY_EDIT,
            PermissionConstants::GALLERY_CATEGORY_DELETE,
            // Certificates
            PermissionConstants::CERTIFICATE_VIEW,
            PermissionConstants::CERTIFICATE_CREATE,
            PermissionConstants::CERTIFICATE_EDIT,
            PermissionConstants::CERTIFICATE_DELETE,
            PermissionConstants::CERTIFICATE_CATEGORY_VIEW,
            PermissionConstants::CERTIFICATE_CATEGORY_CREATE,
            PermissionConstants::CERTIFICATE_CATEGORY_EDIT,
            PermissionConstants::CERTIFICATE_CATEGORY_DELETE,
            // Home Intro
            PermissionConstants::HOME_INTRO_VIEW,
            PermissionConstants::HOME_INTRO_CREATE,
            PermissionConstants::HOME_INTRO_EDIT,
            PermissionConstants::HOME_INTRO_DELETE,
            // Hero Slides & Promos
            PermissionConstants::HERO_SLIDE_VIEW,
            PermissionConstants::HERO_SLIDE_CREATE,
            PermissionConstants::HERO_SLIDE_EDIT,
            PermissionConstants::HERO_SLIDE_DELETE,
            PermissionConstants::PROMO_BANNER_VIEW,
            PermissionConstants::PROMO_BANNER_CREATE,
            PermissionConstants::PROMO_BANNER_EDIT,
            PermissionConstants::PROMO_BANNER_DELETE,
        ];

        $creatorPermissionIds = Permission::whereIn('slug', $creatorPermissions)
            ->pluck('id')
            ->toArray();
        $creatorRole->permissions()->sync($creatorPermissionIds);
        $this->command->line("  ✓ Created Content Creator role with " . count($creatorPermissionIds) . " permissions");

        // HR Manager Role - Manage careers and applicants
        $hrRole = Role::firstOrCreate(
            ['slug' => 'hr-manager'],
            [
                'name' => 'HR Manager',
                'description' => 'Can manage job vacancies, applicants, and screening',
                'is_active' => true,
            ]
        );

        $hrPermissions = [
            PermissionConstants::DASHBOARD_VIEW,
            PermissionConstants::CAREER_VIEW,
            PermissionConstants::CAREER_CREATE,
            PermissionConstants::CAREER_EDIT,
            PermissionConstants::CAREER_DELETE,
            PermissionConstants::CAREER_PUBLISH,
            PermissionConstants::APPLICANT_VIEW,
            PermissionConstants::APPLICANT_SCREEN,
            PermissionConstants::APPLICANT_SHORTLIST,
            PermissionConstants::APPLICANT_REJECT,
            PermissionConstants::APPLICANT_DELETE,
            PermissionConstants::TEAM_VIEW,
        ];

        $hrPermissionIds = Permission::whereIn('slug', $hrPermissions)
            ->pluck('id')
            ->toArray();
        $hrRole->permissions()->sync($hrPermissionIds);
        $this->command->line("  ✓ Created HR Manager role with " . count($hrPermissionIds) . " permissions");

        // Marketing Manager Role - Manage marketing materials
        $marketingRole = Role::firstOrCreate(
            ['slug' => 'marketing-manager'],
            [
                'name' => 'Marketing Manager',
                'description' => 'Can manage promotions, banners, and marketing content',
                'is_active' => true,
            ]
        );

        $marketingPermissions = [
            PermissionConstants::DASHBOARD_VIEW,
            PermissionConstants::PROMO_BANNER_VIEW,
            PermissionConstants::PROMO_BANNER_CREATE,
            PermissionConstants::PROMO_BANNER_EDIT,
            PermissionConstants::PROMO_BANNER_DELETE,
            PermissionConstants::HERO_SLIDE_VIEW,
            PermissionConstants::HERO_SLIDE_CREATE,
            PermissionConstants::HERO_SLIDE_EDIT,
            PermissionConstants::HERO_SLIDE_DELETE,
            PermissionConstants::PRODUCT_VIEW,
            PermissionConstants::PRODUCT_CREATE,
            PermissionConstants::PRODUCT_EDIT,
            PermissionConstants::NEWS_VIEW,
            PermissionConstants::NEWS_CREATE,
            PermissionConstants::NEWS_EDIT,
            PermissionConstants::TESTIMONIAL_VIEW,
            PermissionConstants::TESTIMONIAL_CREATE,
            PermissionConstants::TESTIMONIAL_EDIT,
            PermissionConstants::PARTNER_VIEW,
            PermissionConstants::PARTNER_CREATE,
            PermissionConstants::PARTNER_EDIT,
        ];

        $marketingPermissionIds = Permission::whereIn('slug', $marketingPermissions)
            ->pluck('id')
            ->toArray();
        $marketingRole->permissions()->sync($marketingPermissionIds);
        $this->command->line("  ✓ Created Marketing Manager role with " . count($marketingPermissionIds) . " permissions");

        // Moderator Role - Limited content management (view and delete)
        $moderatorRole = Role::firstOrCreate(
            ['slug' => 'moderator'],
            [
                'name' => 'Moderator',
                'description' => 'Can view and delete user-submitted content',
                'is_active' => true,
            ]
        );

        $moderatorPermissions = [
            PermissionConstants::DASHBOARD_VIEW,
            PermissionConstants::NEWS_VIEW,
            PermissionConstants::NEWS_DELETE,
            PermissionConstants::TESTIMONIAL_VIEW,
            PermissionConstants::TESTIMONIAL_DELETE,
            PermissionConstants::CONTACT_SUBMISSION_VIEW,
            PermissionConstants::CONTACT_SUBMISSION_RESPOND,
            PermissionConstants::CONTACT_SUBMISSION_DELETE,
        ];

        $moderatorPermissionIds = Permission::whereIn('slug', $moderatorPermissions)
            ->pluck('id')
            ->toArray();
        $moderatorRole->permissions()->sync($moderatorPermissionIds);
        $this->command->line("  ✓ Created Moderator role with " . count($moderatorPermissionIds) . " permissions");

        // Viewer Role - Read-only access
        $viewerRole = Role::firstOrCreate(
            ['slug' => 'viewer'],
            [
                'name' => 'Viewer',
                'description' => 'Read-only access to view dashboard and content',
                'is_active' => true,
            ]
        );

        $viewerPermissions = [
            PermissionConstants::DASHBOARD_VIEW,
            PermissionConstants::PRODUCT_VIEW,
            PermissionConstants::PRODUCT_CATEGORY_VIEW,
            PermissionConstants::NEWS_VIEW,
            PermissionConstants::GALLERY_VIEW,
            PermissionConstants::GALLERY_CATEGORY_VIEW,
            PermissionConstants::CERTIFICATE_VIEW,
            PermissionConstants::CERTIFICATE_CATEGORY_VIEW,
            PermissionConstants::TEAM_VIEW,
            PermissionConstants::TESTIMONIAL_VIEW,
            PermissionConstants::PARTNER_VIEW,
            PermissionConstants::COMPANY_INFO_VIEW,
            PermissionConstants::CAREER_VIEW,
            PermissionConstants::APPLICANT_VIEW,
        ];

        $viewerPermissionIds = Permission::whereIn('slug', $viewerPermissions)
            ->pluck('id')
            ->toArray();
        $viewerRole->permissions()->sync($viewerPermissionIds);
        $this->command->line("  ✓ Created Viewer role with " . count($viewerPermissionIds) . " permissions");
    }
}
