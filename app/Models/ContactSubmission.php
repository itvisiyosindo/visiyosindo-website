<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get subject label in Indonesian
     */
    public function getSubjectLabelAttribute(): string
    {
        return match($this->subject) {
            'product' => 'Informasi Produk',
            'quote' => 'Permintaan Penawaran',
            'service' => 'Layanan Purna Jual',
            'partnership' => 'Kerjasama',
            'other' => 'Lainnya',
            default => $this->subject,
        };
    }
}
