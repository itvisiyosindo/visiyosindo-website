<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductContent extends Model
{
    use HasFactory;

    protected $table = 'product_contents';

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'sku',
        'thumbnail',
        'is_active',
        'is_promo',
        'akl_link',
        'brochure_link',
        'ecatalog_link',
        'short_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'features',
        'yt_video_links',
        'product_category_content_id',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'is_promo'        => 'boolean',
        'features'        => 'array',
        'yt_video_links'  => 'array',
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
     * Relasi: Product milik satu Category
     */
    public function category()
    {
        return $this->belongsTo(
            ProductCategoryContent::class,
            'product_category_content_id'
        );
    }

    /**
     * Relasi: Product memiliki satu Detail
     */
    public function detail()
    {
        return $this->hasOne(ProductDetailContent::class);
    }

    /**
     * Relasi: Product memiliki banyak Image
     */
    public function images()
    {
        return $this->hasMany(ImageProduct::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });
    }

    public function getThumbnailUrlAttribute()
    {
        return asset('storage/' . $this->thumbnail);
    }
}
