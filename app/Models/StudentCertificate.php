<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_class_id',
        'training_enrollment_id',
        'certificate_number',
        'verification_code',
        'recipient_name',
        'recipient_institution',
        'pdf_path',
        'original_filename',
        'issued_date',
        'notes',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trainingClass(): BelongsTo
    {
        return $this->belongsTo(TrainingClass::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(TrainingEnrollment::class, 'training_enrollment_id');
    }

    public function getVerificationUrlAttribute(): string
    {
        return route('certificate.verify', $this->verification_code);
    }

    public function getDisplayRecipientNameAttribute(): string
    {
        return $this->recipient_name ?: ($this->user->name ?? 'Peserta');
    }

    public function getDisplayRecipientInstitutionAttribute(): ?string
    {
        return $this->recipient_institution ?: ($this->user->institution ?? null);
    }

    public function hasPdf(): bool
    {
        return !empty($this->pdf_path);
    }
}
