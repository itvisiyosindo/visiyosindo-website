<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrainingEnrollment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'training_class_id',
        'invoice_number',
        'status',
        'payment_method',
        'base_price',
        'discount_amount',
        'final_price',
        'affiliate_code_id',
        'affiliate_commission',
        'commission_awarded_at',
        'payment_proof_path',
        'payment_proof_uploaded_at',
        'approved_at',
        'completed_at',
        'notes',
        'rejection_reason',
    ];

    protected $casts = [
        'base_price' => 'integer',
        'discount_amount' => 'integer',
        'final_price' => 'integer',
        'affiliate_commission' => 'integer',
        'commission_awarded_at' => 'datetime',
        'payment_proof_uploaded_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trainingClass(): BelongsTo
    {
        return $this->belongsTo(TrainingClass::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(StudentCertificate::class);
    }

    public function affiliateCode(): BelongsTo
    {
        return $this->belongsTo(AffiliateCode::class, 'affiliate_code_id');
    }

    public function getEffectiveBasePriceAttribute(): int
    {
        if (($this->base_price ?? 0) > 0) {
            return (int) $this->base_price;
        }

        if (($this->final_price ?? 0) > 0) {
            return (int) $this->final_price;
        }

        return (int) ($this->trainingClass->price ?? 0);
    }

    public function getEffectiveFinalPriceAttribute(): int
    {
        if ($this->invoice_number !== null || ($this->base_price ?? 0) > 0 || ($this->final_price ?? 0) > 0) {
            return (int) ($this->final_price ?? 0);
        }

        return (int) ($this->trainingClass->price ?? 0);
    }

    public function getEffectiveInvoiceNoAttribute(): string
    {
        if (!empty($this->invoice_number)) {
            return (string) $this->invoice_number;
        }

        $date = $this->created_at ?? now();
        return 'INV-VYM-' . $date->format('Ym') . '-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    public function hasPaymentProof(): bool
    {
        return !empty($this->payment_proof_path);
    }

    public function isPaid(): bool
    {
        return in_array($this->status, [self::STATUS_ACTIVE, self::STATUS_COMPLETED], true);
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_ACTIVE => 'Terdaftar / Aktif',
            self::STATUS_COMPLETED => 'Selesai / Lulus',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'amber',
            self::STATUS_ACTIVE => 'blue',
            self::STATUS_COMPLETED => 'emerald',
            self::STATUS_CANCELLED => 'rose',
            default => 'slate',
        };
    }
}
