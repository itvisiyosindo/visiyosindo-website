<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingMaterial extends Model
{
    use HasFactory;

    public const TYPE_PDF = 'pdf';
    public const TYPE_VIDEO = 'video';
    public const TYPE_LINK = 'link';

    protected $fillable = [
        'training_class_id',
        'title',
        'type',
        'file_path',
        'external_url',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function trainingClass(): BelongsTo
    {
        return $this->belongsTo(TrainingClass::class);
    }

    public function isPdf(): bool
    {
        return $this->type === self::TYPE_PDF && !empty($this->file_path);
    }

    public function isVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }
}
