<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingClass extends Model
{
    use HasFactory, SoftDeletes;

    public const PROGRAM_TYPE_TRAINING = 'pelatihan';
    public const PROGRAM_TYPE_WEBINAR = 'webinar';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'program_type',
        'batch_name',
        'instructor',
        'description',
        'syllabus',
        'price',
        'quota',
        'registration_deadline',
        'duration',
        'schedule',
        'location',
        'delivery_mode',
        'whatsapp_group_link',
        'materials_link',
        'image',
        'is_active',
        'is_coming_soon',
    ];

    protected $casts = [
        'price' => 'integer',
        'quota' => 'integer',
        'registration_deadline' => 'date',
        'is_active' => 'boolean',
        'is_coming_soon' => 'boolean',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(TrainingEnrollment::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(StudentCertificate::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(TrainingMaterial::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function activeEnrollmentsCount(): int
    {
        return $this->enrollments()
            ->whereIn('status', [
                TrainingEnrollment::STATUS_PENDING,
                TrainingEnrollment::STATUS_ACTIVE,
                TrainingEnrollment::STATUS_COMPLETED,
            ])
            ->count();
    }

    public function getRemainingQuotaAttribute(): ?int
    {
        if ($this->quota === null || $this->quota <= 0) {
            return null;
        }

        return max(0, $this->quota - $this->activeEnrollmentsCount());
    }

    public function getIsFullAttribute(): bool
    {
        if ($this->quota === null || $this->quota <= 0) {
            return false;
        }

        return $this->remaining_quota <= 0;
    }

    public function getIsDeadlinePassedAttribute(): bool
    {
        if (!$this->registration_deadline) {
            return false;
        }

        return now()->startOfDay()->gt($this->registration_deadline->copy()->endOfDay());
    }

    public function getIsComingSoonProgramAttribute(): bool
    {
        return (bool) $this->is_coming_soon
            || str_contains(strtolower((string) $this->schedule), 'coming soon');
    }

    public function getIsWebinarAttribute(): bool
    {
        return ($this->program_type ?? self::PROGRAM_TYPE_TRAINING) === self::PROGRAM_TYPE_WEBINAR;
    }

    public function getProgramTypeLabelAttribute(): string
    {
        return $this->is_webinar ? 'Webinar' : 'Pelatihan';
    }

    public function getDisplayScheduleAttribute(): string
    {
        if ($this->is_coming_soon && blank($this->schedule)) {
            return 'Coming Soon';
        }

        return $this->schedule ?: 'Menyesuaikan Jadwal';
    }

    public function getIsRegistrationOpenAttribute(): bool
    {
        return (bool) $this->is_active && !$this->is_coming_soon_program && !$this->is_full && !$this->is_deadline_passed;
    }

    public function getDeliveryModeLabelAttribute(): string
    {
        return match ($this->delivery_mode) {
            'offline' => 'Offline (Tatap Muka)',
            'hybrid' => 'Hybrid (Online & Tatap Muka)',
            default => 'Online (Daring)',
        };
    }

    public function getSyllabusItemsAttribute(): array
    {
        if (empty($this->syllabus)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', (string) $this->syllabus);
        $items = [];
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed !== '') {
                $items[] = $trimmed;
            }
        }

        return $items;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price <= 0) {
            return 'Gratis';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }
        return asset('storage/' . $this->image);
    }
}
