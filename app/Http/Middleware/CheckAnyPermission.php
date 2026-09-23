<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class CheckAnyPermission
{
    /**
     * Handle an incoming request.
     *
     * Check if user has ANY of the specified permissions
     * Usage: Route::get('/...', controller)->middleware('any-permission:edit-posts,create-posts')
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

        if ($request->user()->hasAnyPermission($permissions)) {
            return $next($request);
        }

        throw new AuthorizationException('You do not have permission to access this resource.');
    }
}
