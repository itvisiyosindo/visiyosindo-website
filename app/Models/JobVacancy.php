<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $table = 'job_vacancies';

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'type',
        'experience',
        'education',
        'salary_range',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'skills',
        'flyer_image',
        'is_active',
        'is_featured',
        'deadline',
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'requirements'     => 'array',
        'benefits'         => 'array',
        'skills'           => 'array',
        'is_active'        => 'boolean',
        'is_featured'      => 'boolean',
        'deadline'         => 'date',
    ];

    protected $appends = ['encrypted_id'];

    /**
     * Get encrypted ID for URL usage.
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }

    /**
     * Relasi: Vacancy memiliki banyak Application
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope: Only active vacancies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Not expired
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('deadline')
              ->orWhere('deadline', '>=', now()->toDateString());
        });
    }

    /**
     * Check if vacancy is still open
     */
    public function getIsOpenAttribute(): bool
    {
        return $this->is_active && ($this->deadline === null || $this->deadline->isFuture());
    }

    /**
     * Get flyer URL
     */
    public function getFlyerUrlAttribute(): ?string
    {
        return $this->flyer_image ? asset('storage/' . $this->flyer_image) : null;
    }

    /**
     * Get unique departments from all vacancies
     */
    public static function getDepartments(): array
    {
        return static::active()
            ->notExpired()
            ->distinct()
            ->pluck('department')
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }
}
