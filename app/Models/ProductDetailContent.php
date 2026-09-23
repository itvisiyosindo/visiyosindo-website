<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailContent extends Model
{
    use HasFactory;

    protected $table = 'product_detail_contents';

    protected $fillable = [
        'description',
        'specifications',
        'guarantees',
        'guarantee_terms',
        'product_content_id',
    ];

    protected $casts = [
        'specifications'   => 'object',
        'guarantees'       => 'array',
        'guarantee_terms'  => 'array',
    ];

    /**
     * Relasi: Detail milik satu Product
     */
    public function product()
    {
        return $this->belongsTo(ProductContent::class);
    }
}
