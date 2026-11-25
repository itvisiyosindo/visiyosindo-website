<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductInstallation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'product_name',
        'institution_name',
        'location',
        'installation_date',
        'description',
        'image',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'installation_date' => 'date',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    protected $appends = [
        'encrypted_id',
        'image_url',
    ];

    /**
     * Get encrypted ID for routes
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }

    /**
     * Get accessible image URL
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('assets/logo/visiyosindo.png');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'assets/') || str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return Storage::url($this->image);
    }

    /**
     * Get formatted installation date string
     */
    public function getFormattedDateAttribute(): ?string
    {
        if (!$this->installation_date) {
            return null;
        }

        return $this->installation_date->translatedFormat('d F Y');
    }

    /**
     * Scope for active installations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered installations
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('created_at', 'desc');
    }
}
