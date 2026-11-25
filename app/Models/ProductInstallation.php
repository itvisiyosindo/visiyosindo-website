<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ProductInstallation extends Model
{
    use HasFactory, SoftDeletes;

    private static bool $tableEnsured = false;

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
     * Boot the model and ensure table exists automatically.
     */
    protected static function boot()
    {
        parent::boot();
        static::ensureTableExists();
    }

    /**
     * Ensure product_installations table exists idempotently.
     */
    public static function ensureTableExists(): void
    {
        if (static::$tableEnsured) {
            return;
        }

        try {
            if (!Schema::hasTable('product_installations')) {
                Schema::create('product_installations', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->string('product_name')->nullable();
                    $table->string('institution_name')->nullable();
                    $table->string('location')->nullable();
                    $table->date('installation_date')->nullable();
                    $table->text('description')->nullable();
                    $table->string('image');
                    $table->integer('display_order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                    $table->softDeletes();

                    $table->index(['is_active', 'display_order']);
                });

                // Seed initial sample installations so admin has initial data to edit
                DB::table('product_installations')->insert([
                    [
                        'title' => 'Instalasi & Uji Fungsi Stationary X-Ray 500mA',
                        'product_name' => 'Stationary X-Ray 500mA',
                        'institution_name' => 'RSUD Arifin Achmad',
                        'location' => 'Pekanbaru, Riau',
                        'installation_date' => '2026-10-15',
                        'description' => 'Pemasangan unit Stationary X-Ray High Frequency di instalasi radiologi, dilengkapi uji kepatuhan dan keselamatan radiasi sesuai standar BAPETEN serta training staf teknis.',
                        'image' => 'assets/images/deals/deal-1.jpg',
                        'display_order' => 1,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title' => 'Instalasi Mobile DR (Digital Radiography) Unit',
                        'product_name' => 'Mobile DR System',
                        'institution_name' => 'RS Prima Pekanbaru',
                        'location' => 'Pekanbaru, Riau',
                        'installation_date' => '2026-09-20',
                        'description' => 'Penyediaan dan instalasi unit Mobile Digital Radiography untuk kebutuhan mobilitas IGD dan ICU, integrasi jaringan PACS/DICOM rumah sakit, dan uji paparan radiasi.',
                        'image' => 'assets/images/deals/deal-2.jpg',
                        'display_order' => 2,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'title' => 'Pemasangan C-Arm Fluoroscopy Bedah Ortopedi',
                        'product_name' => 'C-Arm Fluoroscopy',
                        'institution_name' => 'RS Awal Bros',
                        'location' => 'Pekanbaru, Riau',
                        'installation_date' => '2026-08-10',
                        'description' => 'Pemasangan dan kalibrasi unit C-Arm resolusi tinggi untuk ruang operasi bedah, memastikan presisi pencitraan real-time dengan paparan radiasi minimum bagi operator dan pasien.',
                        'image' => 'assets/images/deals/deal-3.jpg',
                        'display_order' => 3,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);
            }
            static::$tableEnsured = true;
        } catch (\Throwable $e) {
            // Silently ignore if concurrent execution or lack of DDL permissions
        }
    }

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
