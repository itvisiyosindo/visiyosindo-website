<?php

namespace Tests\Feature\Authorization;

use App\Constants\Permission as PermissionSlug;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed RBAC system for tests
        $this->artisan('db:seed', [
            '--class' => 'RbacSeeder',
        ])->run();

        // Create test users with roles
        $this->createTestUsers();
    }

    private function createTestUsers(): void
    {
        // Admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $admin->assignRole(Role::where('slug', 'admin')->first());

        // Director
        $director = User::factory()->create([
            'name' => 'Director',
            'email' => 'director@test.com',
            'password' => bcrypt('password'),
            'role' => 'director',
        ]);
        $director->assignRole(Role::where('slug', 'director')->first());

        // Content Creator
        $creator = User::factory()->create([
            'name' => 'Creator',
            'email' => 'creator@test.com',
            'password' => bcrypt('password'),
            'role' => 'content_creator',
        ]);
        $creator->assignRole(Role::where('slug', 'content-creator')->first());

        // HR Manager
        $hr = User::factory()->create([
            'name' => 'HR Manager',
            'email' => 'hr@test.com',
            'password' => bcrypt('password'),
            'role' => 'hr',
        ]);
        $hr->assignRole(Role::where('slug', 'hr-manager')->first());

        // Marketing Manager
        $marketing = User::factory()->create([
            'name' => 'Marketing',
            'email' => 'marketing@test.com',
            'password' => bcrypt('password'),
            'role' => 'digital_marketing',
        ]);
        $marketing->assignRole(Role::where('slug', 'marketing-manager')->first());

        // Viewer - use an existing enum value
        $viewer = User::factory()->create([
            'name' => 'Viewer',
            'email' => 'viewer@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',  // Use enum value that exists
        ]);
        $viewer->assignRole(Role::where('slug', 'viewer')->first());
    }

    // ===== PERMISSION CHECKS =====

    public function test_admin_has_all_permissions(): void
    {
        $admin = User::where('email', 'admin@test.com')->first();
        
        $this->assertTrue($admin->hasPermission(PermissionSlug::NEWS_EDIT));
        $this->assertTrue($admin->hasPermission(PermissionSlug::NEWS_DELETE));
        $this->assertTrue($admin->hasPermission(PermissionSlug::USER_ACTIVATE));
    }

    public function test_content_creator_has_content_permissions(): void
    {
        $creator = User::where('email', 'creator@test.com')->first();
        
        $this->assertTrue($creator->hasPermission(PermissionSlug::NEWS_CREATE));
        $this->assertTrue($creator->hasPermission(PermissionSlug::NEWS_EDIT));
        $this->assertTrue($creator->hasPermission(PermissionSlug::PRODUCT_VIEW));
    }

    public function test_content_creator_cannot_delete_users(): void
    {
        $creator = User::where('email', 'creator@test.com')->first();
        
        $this->assertFalse($creator->hasPermission(PermissionSlug::USER_DELETE));
    }

    public function test_director_can_view_analytics(): void
    {
        $director = User::where('email', 'director@test.com')->first();
        
        $this->assertTrue($director->hasPermission(PermissionSlug::ANALYTICS_VIEW));
    }

    public function test_hr_manager_has_career_permissions(): void
    {
        $hr = User::where('email', 'hr@test.com')->first();
        
        $this->assertTrue($hr->hasPermission(PermissionSlug::CAREER_VIEW));
        $this->assertTrue($hr->hasPermission(PermissionSlug::CAREER_CREATE));
        $this->assertTrue($hr->hasPermission(PermissionSlug::APPLICANT_VIEW));
    }

    public function test_marketing_manager_has_promo_permissions(): void
    {
        $marketing = User::where('email', 'marketing@test.com')->first();
        
        $this->assertTrue($marketing->hasPermission(PermissionSlug::PROMO_BANNER_VIEW));
        $this->assertTrue($marketing->hasPermission(PermissionSlug::PROMO_BANNER_CREATE));
    }

    // ===== ROLE CHECKS =====

    public function test_user_has_correct_role(): void
    {
        $admin = User::where('email', 'admin@test.com')->first()->refresh();
        $director = User::where('email', 'director@test.com')->first()->refresh();
        $creator = User::where('email', 'creator@test.com')->first()->refresh();

        $this->assertTrue($admin->hasRole('admin'));
        $this->assertTrue($director->hasRole('director'));
        $this->assertTrue($creator->hasRole('content-creator'));
    }

    public function test_user_cannot_have_wrong_role(): void
    {
        $creator = User::where('email', 'creator@test.com')->first()->refresh();
        $hr = User::where('email', 'hr@test.com')->first()->refresh();

        $this->assertFalse($creator->hasRole('admin'));
        $this->assertFalse($hr->hasRole('director'));
    }

    // ===== PERMISSION COMBINATION CHECKS =====

    public function test_can_check_any_permission(): void
    {
        $creator = User::where('email', 'creator@test.com')->first()->refresh();
        
        $permissions = [
            PermissionSlug::NEWS_EDIT,
            PermissionSlug::USER_DELETE,
        ];

        $this->assertTrue($creator->hasAnyPermission($permissions));
    }

    public function test_can_check_all_permissions(): void
    {
        $creator = User::where('email', 'creator@test.com')->first()->refresh();
        $director = User::where('email', 'director@test.com')->first()->refresh();

        $permissions = [
            PermissionSlug::NEWS_CREATE,
            PermissionSlug::NEWS_EDIT,
            PermissionSlug::NEWS_VIEW,
        ];

        $this->assertTrue($creator->hasAllPermissions($permissions));
        $this->assertFalse($director->hasAllPermissions($permissions)); // Can't create/edit
    }

    // ===== ROLE ASSIGNMENT TESTS =====

    public function test_can_assign_role_to_user(): void
    {
        $user = User::factory()->create();
        $role = Role::where('slug', 'content-creator')->first();

        $user->assignRole($role);
        $user->refresh();

        $this->assertTrue($user->hasRole('content-creator'));
    }

    public function test_can_remove_role_from_user(): void
    {
        $user = User::factory()->create();
        $role = Role::where('slug', 'content-creator')->first();

        $user->assignRole($role);
        $user->refresh();
        $this->assertTrue($user->hasRole('content-creator'));

        $user->removeRole($role);
        $user->refresh();
        $this->assertFalse($user->hasRole('content-creator'));
    }

    // ===== PERMISSION ASSIGNMENT TESTS =====

    public function test_can_give_direct_permission_to_user(): void
    {
        $user = User::factory()->create();
        $permission = PermissionSlug::NEWS_EDIT;

        $user->givePermission($permission);

        $this->assertTrue($user->hasPermission($permission));
    }

    public function test_can_revoke_direct_permission_from_user(): void
    {
        $user = User::factory()->create();
        $permission = PermissionSlug::NEWS_EDIT;

        $user->givePermission($permission);
        $this->assertTrue($user->hasPermission($permission));

        $user->revokePermission($permission);
        $this->assertFalse($user->hasPermission($permission));
    }

    // ===== PERMISSION RETRIEVAL TESTS =====

    public function test_can_filter_permissions_by_category(): void
    {
        $contentPermissions = Permission::getByCategory('content');
        $this->assertNotEmpty($contentPermissions);
    }

    public function test_can_get_active_permissions(): void
    {
        $permissions = Permission::active()->get();
        $this->assertNotEmpty($permissions);
        
        foreach ($permissions as $permission) {
            $this->assertTrue($permission->is_active);
        }
    }

    // ===== ROUTE MIDDLEWARE TESTS =====

    public function test_admin_can_access_dashboard(): void
    {
        $admin = User::where('email', 'admin@test.com')->first();

        $response = $this->actingAs($admin)->get('/dashboard');
        $this->assertNotEquals(403, $response->status());
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $this->assertNotEquals(200, $response->status());
    }

    public function test_content_creator_can_access_news_list(): void
    {
        $creator = User::where('email', 'creator@test.com')->first();

        $response = $this->actingAs($creator)->get('/dashboard/news');
        $this->assertEquals(200, $response->status());
    }

    public function test_viewer_cannot_create_news(): void
    {
        $viewer = User::where('email', 'viewer@test.com')->first();

        // Viewer doesn't have permission to create news
        $this->assertFalse($viewer->hasPermission(PermissionSlug::NEWS_CREATE));
    }

    public function test_viewer_cannot_create_products(): void
    {
        $viewer = User::where('email', 'viewer@test.com')->first();

        // Viewer doesn't have permission to create products
        $this->assertFalse($viewer->hasPermission(PermissionSlug::PRODUCT_CREATE));
    }

    public function test_hr_manager_can_access_careers(): void
    {
        $hr = User::where('email', 'hr@test.com')->first();

        $response = $this->actingAs($hr)->get('/dashboard/careers');
        $this->assertEquals(200, $response->status());
    }

    public function test_marketing_manager_can_access_promo_banners(): void
    {
        $marketing = User::where('email', 'marketing@test.com')->first();

        $response = $this->actingAs($marketing)->get('/dashboard/promo-banners');
        $this->assertEquals(200, $response->status());
    }
}
