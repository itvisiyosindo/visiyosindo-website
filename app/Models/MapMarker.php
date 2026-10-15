<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapMarker extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'type',
        'latitude',
        'longitude',
        'description',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
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
     * Scope to get only active markers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by type
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get marker type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'hospital' => 'Rumah Sakit',
            'clinic' => 'Klinik',
            'lab' => 'Laboratorium',
            default => $this->type,
        };
    }

    /**
     * Get marker icon color based on type
     */
    public function getIconColorAttribute(): string
    {
        return match($this->type) {
            'hospital' => 'blue',
            'clinic' => 'green',
            'lab' => 'orange',
            default => 'gray',
        };
    }
}
