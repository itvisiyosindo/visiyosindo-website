<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'company',
        'content',
        'avatar_path',
        'rating',
        'page_key',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get encrypted ID for routes
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }

    /**
     * Scope to get only active testimonials
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by page
     */
    public function scopeForPage($query, string $pageKey)
    {
        return $query->where('page_key', $pageKey);
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path && Storage::disk('public')->exists($this->avatar_path)) {
            return asset('storage/' . $this->avatar_path);
        }

        // Generate random pravatar if no avatar
        return 'https://i.pravatar.cc/100?img=' . ($this->id % 70 + 1);
    }

    /**
     * Get page name label
     */
    public function getPageNameAttribute(): string
    {
        return match($this->page_key) {
            'visilab-ppr' => 'Visilab - PPR',
            'visilab-uji-kesesuaian' => 'Visilab - Uji Kesesuaian',
            'visilab-uji-paparan' => 'Visilab - Uji Paparan',
            'visilab-uji-kalibrasi' => 'Visilab - Uji Kalibrasi',
            'sgm' => 'SGM',
            default => $this->page_key,
        };
    }

    /**
     * Available pages
     */
    public static function availablePages(): array
    {
        return [
            'visilab-ppr' => 'Visilab - PPR',
            'visilab-uji-kesesuaian' => 'Visilab - Uji Kesesuaian',
            'visilab-uji-paparan' => 'Visilab - Uji Paparan',
            'visilab-uji-kalibrasi' => 'Visilab - Uji Kalibrasi',
            'sgm' => 'SGM',
        ];
    }
}
