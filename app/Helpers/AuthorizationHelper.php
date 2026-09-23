<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Check if current user has a permission
 */
function userCan(string $permission): bool
{
    return Auth::guard('web')->check() && Auth::guard('web')->user()->hasPermission($permission);
}

/**
 * Check if current user has any of the given permissions
 */
function userCanAny(array $permissions): bool
{
    return Auth::guard('web')->check() && Auth::guard('web')->user()->hasAnyPermission($permissions);
}

/**
 * Check if current user has all of the given permissions
 */
function userCanAll(array $permissions): bool
{
    return Auth::guard('web')->check() && Auth::guard('web')->user()->hasAllPermissions($permissions);
}

/**
 * Check if current user has a specific role
 */
function userHasRole(string $role): bool
{
    $user = Auth::guard('web')->user();
    
    if (!$user) {
        return false;
    }

    // Check RBAC roles first
    if ($user->roles()->where('slug', $role)->exists()) {
        return true;
    }

    // Fallback to legacy role column
    return $user->role === $role;
}

/**
 * Check if current user has any of the given roles
 */
function userHasAnyRole(array $roles): bool
{
    $user = Auth::guard('web')->user();
    
    if (!$user) {
        return false;
    }

    // Check RBAC roles
    foreach ($roles as $role) {
        if ($user->roles()->where('slug', $role)->exists()) {
            return true;
        }
        // Fallback to legacy role column
        if ($user->role === $role) {
            return true;
        }
    }

    return false;
}

/**
 * Check if current user is admin
 */
function isAdmin(): bool
{
    $user = Auth::guard('web')->user();
    
    if (!$user) {
        return false;
    }

    // Check RBAC admin role
    if ($user->roles()->where('slug', 'admin')->exists()) {
        return true;
    }

    // Fallback to legacy role
    return $user->role === 'admin' || $user->role === \App\Models\User::ROLE_ADMIN;
}

/**
 * Get current authenticated user
 */
function currentUser(): ?User
{
    return Auth::guard('web')->user();
}

/**
 * Check if user is authenticated
 */
function isAuthenticated(): bool
{
    return Auth::guard('web')->check();
}
