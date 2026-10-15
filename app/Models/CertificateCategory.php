<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CertificateCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    protected $appends = ['encrypted_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($cat) => $cat->slug = $cat->slug ?: Str::slug($cat->name));
    }

    public function certificates() { return $this->hasMany(Certificate::class); }
    
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }
    
    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('order')->orderBy('name'); }
}
