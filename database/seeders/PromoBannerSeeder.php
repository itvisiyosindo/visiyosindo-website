<?php

namespace Database\Seeders;

use App\Models\PromoBanner;
use Illuminate\Database\Seeder;

class PromoBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Open Registration PPR Medik TK II - Batch 6',
                'label' => 'Open Registration Batch 6',
                'description' => 'Ikuti pelatihan bersama Visi Academy! Jadwal Pelatihan: 2-6 Des 2026, Ujian SIB: 7-8 Des 2026 di VISILAB Pekanbaru. Promo diskon 10%.',
                'image_path' => 'assets/images/flyers/ppr-batch-6.jpg',
                'link_url' => 'https://visiyosindo.id/PendaftaranPelatihanPetugasProteksiRadiasiMedikTKII',
                'button_text' => 'Daftar Batch 6',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Visi Academy Membership - Bayar Sekali, Nikmati 1 Tahun Penuh!',
                'label' => 'Program Keanggotaan',
                'description' => 'Hanya Rp100.000/tahun. Nikmati diskon webinar 10%, diskon pelatihan PPR 10%, diskon Training Center 20%, reward referral 10%.',
                'image_path' => 'assets/images/flyers/membership-visilab-academy.jpg',
                'link_url' => 'https://forms.gle/kNpBp9LCQF5yLDWz7',
                'button_text' => 'Daftar Membership',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Visilab Calibration Care+: Program Kontrak Kalibrasi Alat X-Ray',
                'label' => 'Program Kontrak Khusus',
                'description' => 'Layanan kalibrasi selama 3 periode layanan, berkesempatan memperoleh UPAR + gratis 1 kali kalibrasi pada periode tahun ke-4.',
                'image_path' => 'assets/images/flyers/calibration-care.jpg',
                'link_url' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                'button_text' => 'Konsultasi Care+',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Webinar Visi Academy: Pemahaman Regulasi Penggunaan Portable X-Ray',
                'label' => 'Webinar Visi Academy',
                'description' => 'Pahami regulasi penggunaan Portable X-Ray bersama BAPETEN. 25 Nov 2026, 08.30 WIB via Online Meeting. Early bird Rp35.000 (s/d 11 Nov).',
                'image_path' => 'assets/images/flyers/webinar-portable-xray.jpg',
                'link_url' => 'https://bit.ly/PemahamanRegulasiMengenaiPenggunaanPortableX-RaypadaPemeriksaanKesehatan',
                'button_text' => 'Daftar Webinar',
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            PromoBanner::updateOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}
