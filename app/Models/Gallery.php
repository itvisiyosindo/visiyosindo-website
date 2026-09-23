<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gallery_category_id',
        'title',
        'description',
        'image',
        'size',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['encrypted_id'];

    /**
     * Get encrypted ID for URL usage.
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return asset('images/placeholder-gallery.jpg');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('gallery_category_id', $categoryId);
    }
}
