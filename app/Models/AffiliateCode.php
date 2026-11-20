<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateCode extends Model
{
    use HasFactory;

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
}
