<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryContent extends Model
{
    use HasFactory;

    protected $table = 'product_category_contents';

    protected $fillable = [
        'name',
        'slug',
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

    /**
     * Relasi: Category memiliki banyak Product
     */
    public function products()
    {
        return $this->hasMany(ProductContent::class, 'product_category_content_id');
    }
}
