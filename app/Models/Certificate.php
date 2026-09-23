<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Certificate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['certificate_category_id', 'title', 'description', 'image', 'issuer', 'cert_number', 'issued_date', 'valid_until', 'status', 'order', 'is_active'];
    protected $casts = ['is_active' => 'boolean', 'issued_date' => 'date', 'valid_until' => 'date'];
    protected $appends = ['encrypted_id'];

    public function category() { return $this->belongsTo(CertificateCategory::class, 'certificate_category_id'); }
    
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }
    
    public function getImageUrlAttribute() {
        return $this->image && Storage::disk('public')->exists($this->image) 
            ? asset('storage/' . $this->image)
            : asset('images/placeholder.jpg');
    }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('order')->orderBy('created_at', 'desc'); }
}
