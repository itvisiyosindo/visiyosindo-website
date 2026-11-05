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
            // Deactivate old banners
            PromoBanner::where('is_active', true)->update(['is_active' => false]);

            PromoBanner::updateOrCreate(
                ['title' => 'Open Registration PPR Medik TK II - Batch 6'],
                [
                    'label' => 'Open Registration Batch 6',
                    'description' => 'Ikuti pelatihan bersama Visi Academy! Jadwal Pelatihan: 2-6 Des 2026, Ujian SIB: 7-8 Des 2026 di VISILAB Pekanbaru. Promo diskon 10%.',
                    'image_path' => 'assets/images/flyers/ppr-batch-6.jpg',
                    'link_url' => 'https://visiyosindo.id/PendaftaranPelatihanPetugasProteksiRadiasiMedikTKII',
                    'button_text' => 'Daftar Batch 6',
                    'display_order' => 1,
                    'is_active' => true,
                ]
            );

            PromoBanner::updateOrCreate(
                ['title' => 'Visi Academy Membership - Bayar Sekali, Nikmati 1 Tahun Penuh!'],
                [
                    'label' => 'Program Keanggotaan',
                    'description' => 'Hanya Rp100.000/tahun. Nikmati diskon webinar 10%, diskon pelatihan PPR 10%, diskon Training Center 20%, reward referral 10%.',
                    'image_path' => 'assets/images/flyers/membership-visilab-academy.jpg',
                    'link_url' => 'https://forms.gle/kNpBp9LCQF5yLDWz7',
                    'button_text' => 'Daftar Membership',
                    'display_order' => 2,
                    'is_active' => true,
                ]
            );

            PromoBanner::updateOrCreate(
                ['title' => 'Visilab Calibration Care+: Program Kontrak Kalibrasi Alat X-Ray'],
                [
                    'label' => 'Program Kontrak Khusus',
                    'description' => 'Layanan kalibrasi selama 3 periode layanan, berkesempatan memperoleh UPAR + gratis 1 kali kalibrasi pada periode tahun ke-4.',
                    'image_path' => 'assets/images/flyers/calibration-care.jpg',
                    'link_url' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                    'button_text' => 'Konsultasi Care+',
                    'display_order' => 3,
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
        // Keep records
    }
};
