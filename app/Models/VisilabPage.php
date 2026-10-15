<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisilabPage extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'hero_title',
        'hero_description',
        'intro_title',
        'intro_description',
        'intro_images',
        'services_title',
        'services_content',
        'process_title',
        'process_steps',
        'cta_title',
        'cta_description',
        'additional_data',
        'is_active',
    ];

    protected $casts = [
        'intro_images' => 'array',
        'services_content' => 'array',
        'process_steps' => 'array',
        'additional_data' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get page by slug
     */
    public static function getBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Get all active pages
     */
    public static function getActivePages()
    {
        return static::where('is_active', true)
            ->orderBy('slug')
            ->get();
    }

    /**
     * Available page slugs
     */
    public static function availablePages(): array
    {
        return [
            'uji-kalibrasi' => 'Uji Kalibrasi',
            'uji-paparan' => 'Uji Paparan',
            'uji-kesesuaian' => 'Uji Kesesuaian',
            'ppr' => 'Pelatihan Petugas Radiasi (PPR)',
        ];
    }
}

