<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'category', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    /**
     * Get all roles with this permission
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Get all users with this permission (through roles)
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions')
            ->withTimestamps();
    }

    /**
     * Get permissions grouped by category
     */
    public static function getByCategory(string $category)
    {
        return static::where('category', $category)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get all categories
     */
    public static function getCategories()
    {
        return static::where('is_active', true)
            ->distinct('category')
            ->pluck('category')
            ->sort();
    }

    /**
     * Scope to active permissions only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
