<?php

use App\Models\PromoBanner;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            PromoBanner::updateOrCreate(
                ['title' => 'Webinar Visi Academy: Pemahaman Regulasi Penggunaan Portable X-Ray'],
                [
                    'label' => 'Webinar Visi Academy',
                    'description' => 'Pahami regulasi penggunaan Portable X-Ray bersama BAPETEN. 25 Nov 2026, 08.30 WIB via Online Meeting. Early bird Rp35.000 (s/d 11 Nov).',
                    'image_path' => 'assets/images/flyers/webinar-portable-xray.jpg',
                    'link_url' => 'https://bit.ly/PemahamanRegulasiMengenaiPenggunaanPortableX-RaypadaPemeriksaanKesehatan',
                    'button_text' => 'Daftar Webinar',
                    'display_order' => 4,
                    'is_active' => true,
                ]
            );
        } catch (\Throwable $e) {
            // Ignore error if table not ready
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            PromoBanner::where('title', 'like', '%Portable X-Ray%')->delete();
        } catch (\Throwable $e) {
            // Ignore error
        }
    }
};
