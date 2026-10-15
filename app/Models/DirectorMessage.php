<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Model;

class DirectorMessage extends Model
{
    protected $fillable = [
        'name',
        'position',
        'photo',
        'headline_quote',
        'welcome_message',
        'linkedin_url',
        'facebook_url',
        'email',
        'years_experience',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'years_experience' => 'integer',
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
     * Scope to get only active director message.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
