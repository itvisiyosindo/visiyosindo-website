<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'province',
        'phone',
        'email',
        'maps_embed_url',
        'latitude',
        'longitude',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'display_order' => 'integer',
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
}
