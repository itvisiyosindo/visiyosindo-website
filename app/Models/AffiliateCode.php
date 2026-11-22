<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AffiliateCode extends Model
{
    use HasFactory;

    public const DEFAULT_DISCOUNT_PERCENT = 5;
    public const DEFAULT_COMMISSION_PERCENT = 2;

    protected $fillable = [
        'user_id',
        'code',
        'discount_percent',
        'commission_percent',
        'usage_count',
        'total_commission',
        'is_active',
    ];

    protected $casts = [
        'discount_percent' => 'integer',
        'commission_percent' => 'integer',
        'usage_count' => 'integer',
        'total_commission' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(TrainingEnrollment::class, 'affiliate_code_id');
    }
}
