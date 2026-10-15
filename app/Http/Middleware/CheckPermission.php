<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * Check if user has specific permission
     * Usage: Route::get('/...', controller)->middleware('permission:edit-posts')
     */
    public function handle(Request $request, Closure $next, string ...$permissions): mixed
    {
        if (!$request->user()) {
            throw new AuthorizationException('Unauthorized');
        }

        // Admin users have full access without exceptions
        if ($request->user()->isAdmin()) {
            return $next($request);
        }

        // Check if user has all permissions
        if ($request->user()->hasAllPermissions($permissions)) {
            return $next($request);
        }

        throw new AuthorizationException('You do not have permission to access this resource.');
    }
}
