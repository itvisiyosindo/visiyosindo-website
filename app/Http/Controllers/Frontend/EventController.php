<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use App\Models\TrainingClass;
use App\Support\AcademySchemaEnsurer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of upcoming events, webinars, and training agendas.
     */
    public function index(Request $request)
    {
        // 1. Fetch active Promo Banners (Webinars, Special Deals, PPR Registration, Contracts)
        $dbPromoBanners = PromoBanner::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        if ($dbPromoBanners->isNotEmpty()) {
            $events = $dbPromoBanners->map(function ($banner) {
                $lowerTitle = strtolower($banner->title ?? '');
                $imagePath = $banner->image_path ?? '';
                $basename = basename($imagePath);

                $isPpr = str_contains($lowerTitle, 'ppr') || str_contains($lowerTitle, 'radiasi') || str_contains($lowerTitle, 'batch 6');
                $isMember = str_contains($lowerTitle, 'member');
                $isCalib = str_contains($lowerTitle, 'kalibrasi') || str_contains($lowerTitle, 'care');
                $isWebinar = str_contains($lowerTitle, 'webinar') || str_contains($lowerTitle, 'portable');

                if ($isPpr) {
                    $category = 'pelatihan';
                    $categoryLabel = 'Pelatihan & Ujian SIB';
                    $stubMonth = 'Pelatihan';
                    $stubDay = '02-06';
                    $stubYear = 'DES 2026';
                    $stubLocation = 'PEKANBARU';
                    $badge = 'SIB MEDIK TK II';
                    $highlights = [
                        '📅 Ujian SIB: 07 - 08 Des 2026',
                        '📍 VISILAB Pekanbaru',
                        '🎓 Biaya: Rp6.000.000',
                        '🎁 Promo Diskon 10%',
                        '📲 Kuota Terbatas',
                    ];
                } elseif ($isMember) {
                    $category = 'program';
                    $categoryLabel = 'Membership';
                    $stubMonth = 'Membership';
                    $stubDay = '1 TAHUN';
                    $stubYear = '2026';
                    $stubLocation = 'VISI ACADEMY';
                    $badge = 'ALL ACCESS PASS';
                    $highlights = [
                        '💰 Hanya Rp100.000/tahun',
                        '🎓 Diskon Webinar SKP 10%',
                        '⚡ Diskon Pelatihan PPR 10%',
                        '🏥 Training Center Diskon 20%',
                        '✨ Akses Prioritas Program & Webinar',
                    ];
                } elseif ($isCalib) {
                    $category = 'program';
                    $categoryLabel = 'Kontrak Khusus';
                    $stubMonth = 'KONTRAK RESMI';
                    $stubDay = '3 TAHUN';
                    $stubYear = '2026';
                    $stubLocation = 'VISILAB CARE+';
                    $badge = 'STANDAR BAPETEN';
                    $highlights = [
                        '🏥 Mobile, Portable & Stationary X-Ray',
                        '🎁 Gratis 1x Kalibrasi + UPAR Thn ke-4',
                        '📋 Kontrak 3 Periode Layanan',
                        '🛡️ Jaminan Standar BAPETEN',
                    ];
                } elseif ($isWebinar) {
                    $category = 'webinar';
                    $categoryLabel = 'Webinar Resmi';
                    $stubMonth = 'Webinar';
                    $stubDay = '25';
                    $stubYear = 'NOV 2026';
                    $stubLocation = 'ONLINE';
                    $badge = 'SKP / BAPETEN';
                    $highlights = [
                        '🎙️ Narasumber: Perwakilan BAPETEN',
                        '⏰ 25 Nov 2026 • 08.30 WIB',
                        '🎁 E-Certificate, Materi & Rekaman',
                        '🏷️ Early Bird Rp35.000 (s/d 11 Nov)',
                        '📲 Kuota Terbatas',
                    ];
                } else {
                    $category = 'agenda';
                    $categoryLabel = 'Agenda Resmi';
                    $stubMonth = 'AGENDA';
                    $stubDay = date('d');
                    $stubYear = date('M Y');
                    $stubLocation = 'OFFICIAL';
                    $badge = 'AGENDA TERBARU';
                    $highlights = array_filter([
                        $banner->description ? Str::limit($banner->description, 40) : null,
                        '📍 Pekanbaru',
                        '📲 Pendaftaran Dibuka'
                    ]);
                }

                // Resolve image URL
                if (str_contains($lowerTitle, 'kalibrasi') || str_contains($lowerTitle, 'care') || str_contains(strtolower($basename), 'calibration')) {
                    $resolvedImage = url('/assets/images/flyers/calibration-care.jpg');
                } elseif (str_contains($lowerTitle, 'member') || str_contains(strtolower($basename), 'membership')) {
                    $resolvedImage = url('/assets/images/flyers/membership-visilab-academy.jpg');
                } elseif (str_contains($lowerTitle, 'ppr') || str_contains($lowerTitle, 'radiasi') || str_contains($lowerTitle, 'batch') || str_contains(strtolower($basename), 'ppr')) {
                    $resolvedImage = url('/assets/images/flyers/ppr-batch-6.jpg');
                } elseif (str_contains($lowerTitle, 'webinar') || str_contains($lowerTitle, 'portable') || str_contains(strtolower($basename), 'webinar')) {
                    $resolvedImage = url('/assets/images/flyers/webinar-portable-xray.jpg');
                } elseif (str_starts_with($imagePath, 'http')) {
                    $resolvedImage = $imagePath;
                } elseif (str_starts_with($imagePath, 'assets/')) {
                    $resolvedImage = asset($imagePath);
                } else {
                    $resolvedImage = url('/assets/images/flyers/' . $basename);
                }

                return [
                    'id' => $banner->id,
                    'category' => $category,
                    'category_label' => $categoryLabel,
                    'stub_month' => $stubMonth,
                    'stub_day' => $stubDay,
                    'stub_year' => $stubYear,
                    'stub_location' => $stubLocation,
                    'badge' => $badge,
                    'label' => __($banner->label ?: $categoryLabel),
                    'title' => __($banner->title ?? ''),
                    'description' => __($banner->description ?? ''),
                    'highlights' => $highlights,
                    'buttonText' => __($banner->button_text ?: 'Daftar Sekarang'),
                    'link' => $banner->link_url ?? '#',
                    'contactText' => 'Info WA: 0895-0724-0145',
                    'contactLink' => $isWebinar 
                        ? 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20ingin%20tanya%20tentang%20Webinar%20Regulasi%20Portable%20X-Ray'
                        : ($isCalib 
                            ? 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B'
                            : 'https://wa.me/6289507240145'),
                    'image' => $resolvedImage,
                ];
            });
        } else {
            $events = collect([
                [
                    'id' => 1,
                    'category' => 'pelatihan',
                    'category_label' => 'Pelatihan & Ujian SIB',
                    'stub_month' => 'Pelatihan',
                    'stub_day' => '02-06',
                    'stub_year' => 'DES 2026',
                    'stub_location' => 'PEKANBARU',
                    'badge' => 'SIB MEDIK TK II',
                    'label' => __('Open Registration Batch 6'),
                    'title' => __('Open Registration PPR Medik TK II - Batch 6'),
                    'description' => __('Ikuti pelatihan bersama Visi Academy! Pembelajaran teori, praktik langsung di RS, serta simulasi ujian tertulis, praktik & wawancara.'),
                    'highlights' => [
                        '📅 Ujian SIB: 07 - 08 Des 2026',
                        '📍 VISILAB Pekanbaru',
                        '🎓 Biaya: Rp6.000.000',
                        '🎁 Promo Diskon 10%',
                        '📲 Kuota Terbatas',
                    ],
                    'buttonText' => __('Daftar Batch 6'),
                    'link' => 'https://visiyosindo.id/PendaftaranPelatihanPetugasProteksiRadiasiMedikTKII',
                    'contactText' => 'Info WA: 0895-0724-0145',
                    'contactLink' => 'https://wa.me/6289507240145',
                    'image' => url('/assets/images/flyers/ppr-batch-6.jpg'),
                ],
                [
                    'id' => 2,
                    'category' => 'webinar',
                    'category_label' => 'Webinar Resmi',
                    'stub_month' => 'Webinar',
                    'stub_day' => '25',
                    'stub_year' => 'NOV 2026',
                    'stub_location' => 'ONLINE',
                    'badge' => 'SKP / BAPETEN',
                    'label' => __('Webinar Visi Academy'),
                    'title' => __('Webinar Visi Academy: Pemahaman Regulasi Penggunaan Portable X-Ray'),
                    'description' => __('Pahami regulasi penggunaan Portable X-Ray bersama BAPETEN. 25 Nov 2026, 08.30 WIB via Online Meeting. Early bird Rp35.000 (s/d 11 Nov).'),
                    'highlights' => [
                        '🎙️ Narasumber: Perwakilan BAPETEN',
                        '⏰ 25 Nov 2026 • 08.30 WIB',
                        '🎁 E-Certificate, Materi & Rekaman',
                        '🏷️ Early Bird Rp35.000 (s/d 11 Nov)',
                        '📲 Kuota Terbatas',
                    ],
                    'buttonText' => __('Daftar Webinar'),
                    'link' => 'https://bit.ly/PemahamanRegulasiMengenaiPenggunaanPortableX-RaypadaPemeriksaanKesehatan',
                    'contactText' => 'Info WA: 0895-0724-0145',
                    'contactLink' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20ingin%20tanya%20tentang%20Webinar%20Regulasi%20Portable%20X-Ray',
                    'image' => url('/assets/images/flyers/webinar-portable-xray.jpg'),
                ],
                [
                    'id' => 3,
                    'category' => 'program',
                    'category_label' => 'Kontrak Khusus',
                    'stub_month' => 'KONTRAK RESMI',
                    'stub_day' => '3 TAHUN',
                    'stub_year' => '2026',
                    'stub_location' => 'VISILAB CARE+',
                    'badge' => 'STANDAR BAPETEN',
                    'label' => __('Program Kontrak Khusus'),
                    'title' => __('Visilab Calibration Care+: Program Kontrak Kalibrasi Alat X-Ray'),
                    'description' => __('Layanan kalibrasi selama 3 periode layanan, berkesempatan memperoleh UPAR + gratis 1 kali kalibrasi pada periode tahun ke-4.'),
                    'highlights' => [
                        '🏥 Mobile, Portable & Stationary X-Ray',
                        '🎁 Gratis 1x Kalibrasi + UPAR Thn ke-4',
                        '📋 Kontrak 3 Periode Layanan',
                        '🛡️ Jaminan Standar BAPETEN',
                    ],
                    'buttonText' => __('Konsultasi Care+'),
                    'link' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                    'contactText' => 'Info WA: 0895-0724-0145',
                    'contactLink' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                    'image' => url('/assets/images/flyers/calibration-care.jpg'),
                ],
            ]);
        }

        // 2. Fetch active training & webinar programs from Visi Academy
        try {
            AcademySchemaEnsurer::ensure();

            $trainingClasses = TrainingClass::where('is_active', true)
                ->orderBy('id', 'desc')
                ->get();
        } catch (\Throwable $e) {
            $trainingClasses = collect();
        }

        return view('pages.events', compact('events', 'trainingClasses'));
    }
}
