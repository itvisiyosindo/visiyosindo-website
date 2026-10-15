<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Check if user has specific role (via role_id or direct role)
     * Usage: Route::get('/...', controller)->middleware('role:admin,director')
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (!$request->user()) {
            throw new AuthorizationException('Unauthorized');
        }

        $user = $request->user();

        // Admin users have full access without exceptions
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Check if user has any of the roles (via user_roles table)
        $hasRole = $user->roles()
            ->whereIn('slug', $roles)
            ->exists();

        // Also check legacy role column for backward compatibility
        if (!$hasRole && in_array($user->role, $roles)) {
            $hasRole = true;
        }

        if ($hasRole) {
            return $next($request);
        }

        throw new AuthorizationException('You do not have the required role to access this resource.');
    }
}
