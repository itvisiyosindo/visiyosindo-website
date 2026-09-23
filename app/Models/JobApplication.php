<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_applications';

    protected $fillable = [
        'job_vacancy_id',
        'full_name',
        'email',
        'phone',
        'birth_date',
        'address',
        'education',
        'major',
        'institution',
        'graduation_year',
        'work_experience',
        'last_job',
        'cv_path',
        'transcript_path',  // Changed from ktp_path for security & relevance
        'ijazah_path',
        'status',
        'notes',
        // Auto-screening fields
        'match_score',
        'education_match',
        'major_match',
        'skill_match',
        'experience_match',
        'recommendation',
        'screening_details',
        'screened_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'screening_details' => 'array',
        'screened_at' => 'datetime',
        'match_score' => 'decimal:2',
        'education_match' => 'decimal:2',
        'major_match' => 'decimal:2',
        'skill_match' => 'decimal:2',
        'experience_match' => 'decimal:2',
    ];

    protected $appends = ['encrypted_id'];

    /**
     * Status labels for display
     */
    public const STATUS_LABELS = [
        'pending'     => 'Menunggu',
        'reviewed'    => 'Direview',
        'shortlisted' => 'Shortlist',
        'interview'   => 'Interview',
        'accepted'    => 'Diterima',
        'rejected'    => 'Ditolak',
    ];

    /**
     * Status colors for badges
     */
    public const STATUS_COLORS = [
        'pending'     => 'warning',
        'reviewed'    => 'info',
        'shortlisted' => 'primary',
        'interview'   => 'secondary',
        'accepted'    => 'success',
        'rejected'    => 'danger',
    ];

    /**
     * Get encrypted ID for URL usage.
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }

    /**
     * Relasi: Application milik satu Vacancy
     */
    public function vacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get status color for badge
     */
    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

}
