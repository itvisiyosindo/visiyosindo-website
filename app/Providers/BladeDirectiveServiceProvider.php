<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class BladeDirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /**
         * @can('permission-slug')
         *     User has permission
         * @endcan
         */
        Blade::directive('can', function ($permission) {
            return "<?php if(\$user = auth()->user()): if(\$user->hasPermission({$permission})): ?>";
        });

        Blade::directive('endcan', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @cannot('permission-slug')
         *     User does not have permission
         * @endcannot
         */
        Blade::directive('cannot', function ($permission) {
            return "<?php if(\$user = auth()->user()): if(!(\$user->hasPermission({$permission}))): ?>";
        });

        Blade::directive('endcannot', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @hasRole('role-slug')
         *     User has role
         * @endhasRole
         */
        Blade::directive('hasRole', function ($role) {
            return "<?php if(\$user = auth()->user()): if(\$user->hasRole({$role})): ?>";
        });

        Blade::directive('endhasRole', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @hasAnyRole(['admin', 'director'])
         *     User has any of the roles
         * @endhasAnyRole
         */
        Blade::directive('hasAnyRole', function ($roles) {
            return "<?php if(\$user = auth()->user()): if(\$user->hasRole(array({$roles}))): ?>";
        });

        Blade::directive('endhasAnyRole', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @canAny(['permission1', 'permission2'])
         *     User has any of the permissions
         * @endcanAny
         */
        Blade::directive('canAny', function ($permissions) {
            return "<?php if(\$user = auth()->user()): if(\$user->hasAnyPermission({$permissions})): ?>";
        });

        Blade::directive('endcanAny', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @canAll(['permission1', 'permission2'])
         *     User has all permissions
         * @endcanAll
         */
        Blade::directive('canAll', function ($permissions) {
            return "<?php if(\$user = auth()->user()): if(\$user->hasAllPermissions({$permissions})): ?>";
        });

        Blade::directive('endcanAll', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @admin
         *     Only for admin users
         * @endadmin
         */
        Blade::directive('admin', function () {
            return "<?php if(\$user = auth()->user()): if(\$user->hasRole('admin')): ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @notAdmin
         *     For non-admin users
         * @endnotAdmin
         */
        Blade::directive('notAdmin', function () {
            return "<?php if(\$user = auth()->user()): if(!(\$user->hasRole('admin'))): ?>";
        });

        Blade::directive('endnotAdmin', function () {
            return "<?php endif; endif; ?>";
        });

        /**
         * @authenticated
         *     User is authenticated
         * @endauthenticated
         */
        Blade::directive('authenticated', function () {
            return "<?php if(auth()->check()): ?>";
        });

        Blade::directive('endauthenticated', function () {
            return "<?php endif; ?>";
        });

        /**
         * @guest
         *     User is not authenticated
         * @endguest
         */
        Blade::directive('guest', function () {
            return "<?php if(!auth()->check()): ?>";
        });

        Blade::directive('endguest', function () {
            return "<?php endif; ?>";
        });
    }
}
