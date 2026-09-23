<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeIntroduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image_path',
        'video_url',
        'additional_image_1',
        'additional_image_2',
        'additional_image_3',
        'features',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    protected $appends = ['encrypted_id'];

    /**
     * Get encrypted ID for URL usage.
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }
}
