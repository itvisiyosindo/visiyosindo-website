<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Role Constants
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CONTENT_CREATOR = 'content_creator';
    public const ROLE_DIGITAL_MARKETING = 'digital_marketing';
    public const ROLE_HR = 'hr';
    public const ROLE_DIRECTOR = 'director';

    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_CONTENT_CREATOR => 'Content Creator',
        self::ROLE_DIGITAL_MARKETING => 'Digital Marketing',
        self::ROLE_HR => 'HR',
        self::ROLE_DIRECTOR => 'Director',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'avatar',
        'preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'preferences' => 'array',
        ];
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Get all roles for this user
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }

    /**
     * Get all direct permissions for this user
     */
    public function directPermissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions')
            ->withTimestamps();
    }

    /**
     * Get all permissions through roles and direct permissions
     */
    public function getPermissions()
    {
        $rolePermissions = $this->roles()
            ->with('permissions')
            ->get()
            ->flatMap(fn($role) => $role->permissions)
            ->keyBy('id');

        $directPermissions = $this->directPermissions()->get()->keyBy('id');

        return $rolePermissions->merge($directPermissions)->values();
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $slug): bool
    {
        // Check direct permissions
        if ($this->directPermissions()
            ->where('slug', $slug)
            ->exists()) {
            return true;
        }

        // Check role permissions
        return $this->roles()
            ->whereHas('permissions', fn($q) => $q->where('slug', $slug))
            ->exists();
    }

    /**
     * Check if user has any of the permissions
     */
    public function hasAnyPermission(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if ($this->hasPermission($slug)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has all permissions
     */
    public function hasAllPermissions(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if (!$this->hasPermission($slug)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Assign role to user
     */
    public function assignRole(Role|string $role): void
    {
        $role = $this->resolveRole($role);
        
        if (!$this->roles()->where('id', $role->id)->exists()) {
            $this->roles()->attach($role);
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(Role|string $role): void
    {
        $role = $this->resolveRole($role);
        $this->roles()->detach($role);
    }

    /**
     * Give direct permission to user
     */
    public function givePermission(Permission|string $slug): void
    {
        $permission = $this->resolvePermission($slug);
        
        if (!$this->directPermissions()->where('id', $permission->id)->exists()) {
            $this->directPermissions()->attach($permission);
        }
    }

    /**
     * Remove direct permission from user
     */
    public function revokePermission(Permission|string $slug): void
    {
        $permission = $this->resolvePermission($slug);
        $this->directPermissions()->detach($permission);
    }

    /**
     * Resolve role model or name
     */
    protected function resolveRole(Role|string $role): Role
    {
        if ($role instanceof Role) {
            return $role;
        }

        return Role::where('slug', $role)->firstOrFail();
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
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        // Check new RBAC system first (user_roles table)
        if ($this->roles()->where('slug', $role)->exists()) {
            return true;
        }

        // Fallback to legacy role column for backward compatibility
        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        // Check RBAC system first
        if ($this->hasRole('admin')) {
            return true;
        }
        
        // Fallback to legacy role column
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is director
     */
    public function isDirector(): bool
    {
        return $this->role === self::ROLE_DIRECTOR;
    }

    /**
     * Get role display name
     */
    public function getRoleNameAttribute(): string
    {
        return self::ROLES[$this->role] ?? $this->role;
    }

    /**
     * Get user initials for avatar
     */
    public function getInitialsAttribute(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach (array_slice($names, 0, 2) as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return $initials;
    }

    /**
     * Get avatar URL for UI rendering.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (empty($this->avatar)) {
            return null;
        }

        return asset('storage/' . $this->avatar);
    }

    /**
     * Resolve notification preference with fallback default.
     */
    public function notificationPreference(string $key, bool $default = true): bool
    {
        return (bool) data_get($this->preferences ?? [], "notifications.{$key}", $default);
    }
}
