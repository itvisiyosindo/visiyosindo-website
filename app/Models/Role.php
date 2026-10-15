<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    /**
     * Get all permissions for this role
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Get all users with this role
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->withTimestamps();
    }

    /**
     * Check if role has permission
     */
    public function hasPermission(string $slug): bool
    {
        return $this->permissions()
            ->where('slug', $slug)
            ->exists();
    }

    /**
     * Check if role has any of the permissions
     */
    public function hasAnyPermission(array $slugs): bool
    {
        return $this->permissions()
            ->whereIn('slug', $slugs)
            ->exists();
    }

    /**
     * Check if role has all permissions
     */
    public function hasAllPermissions(array $slugs): bool
    {
        return count($slugs) === $this->permissions()
            ->whereIn('slug', $slugs)
            ->count();
    }

    /**
     * Give permission to role
     */
    public function givePermission(Permission|string $slug): void
    {
        $permission = $this->resolvePermission($slug);
        
        if (!$this->hasPermission($permission->slug)) {
            $this->permissions()->attach($permission);
        }
    }

    /**
     * Remove permission from role
     */
    public function revokePermission(Permission|string $slug): void
    {
        $permission = $this->resolvePermission($slug);
        $this->permissions()->detach($permission);
    }

    /**
     * Sync permissions for role
     */
    public function syncPermissions(array $slugs): void
    {
        $permissions = Permission::whereIn('slug', $slugs)->pluck('id');
        $this->permissions()->sync($permissions);
    }

    /**
     * Resolve permission model or slug
     */
    protected function resolvePermission(Permission|string $permission): Permission
    {
        if ($permission instanceof Permission) {
            return $permission;
        }

        return Permission::where('slug', $permission)->firstOrFail();
    }

    /**
     * Get role name display
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn() => ucfirst($this->name),
        );
    }
}
