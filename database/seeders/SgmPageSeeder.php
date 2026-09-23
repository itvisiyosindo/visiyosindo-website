<?php

namespace Database\Seeders;

use App\Models\SgmPage;
use Illuminate\Database\Seeder;

class SgmPageSeeder extends Seeder
{
    public function run(): void
    {
        SgmPage::create([
            'hero_title' => 'PT Sumpah Gajah Mada',
            'hero_subtitle' => 'Anak perusahaan PT Visi Yosindo Medikal yang berkomitmen untuk memberikan solusi terbaik dalam industri kesehatan.',
            
            'company_name' => 'PT Sumpah Gajah Mada',
            'founded_year' => 2020,
            'company_description' => 'PT Sumpah Gajah Mada (SGM) adalah anak perusahaan dari PT Visi Yosindo Medikal yang didirikan untuk memperluas jangkauan layanan dan produk dalam industri kesehatan. Dengan dukungan penuh dari perusahaan induk, SGM berkomitmen untuk memberikan solusi inovatif dan berkualitas tinggi.',
            'about_text' => 'Kami fokus pada pengembangan dan distribusi produk-produk kesehatan yang memenuhi standar internasional, serta memberikan layanan purna jual yang prima untuk kepuasan pelanggan.',
            
            'vision_text' => 'Menjadi perusahaan terdepan dalam industri kesehatan yang memberikan kontribusi nyata bagi peningkatan kualitas layanan kesehatan di Indonesia melalui inovasi produk dan layanan yang berkelanjutan.',
            
            'mission_items' => [
                'Menyediakan produk kesehatan berkualitas tinggi dengan harga kompetitif',
                'Memberikan layanan purna jual yang profesional dan responsif',
                'Membangun kemitraan yang saling menguntungkan dengan stakeholder',
                'Berkontribusi pada pengembangan SDM kesehatan Indonesia',
            ],
            
            'info_cards' => [
                [
                    'title' => 'Terpercaya',
                    'description' => 'Kualitas terjamin',
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                ],
                [
                    'title' => 'Inovatif',
                    'description' => 'Solusi terkini',
                    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                ],
                [
                    'title' => 'Profesional',
                    'description' => 'Tim ahli berpengalaman',
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                ],
                [
                    'title' => 'Jangkauan Luas',
                    'description' => 'Seluruh Indonesia',
                    'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
            ],
            
            'services_title' => 'Sertifikat Kami',
            'services_subtitle' => 'SGM telah tersertifikasi dengan berbagai standar internasional untuk menjamin kualitas produk dan layanan terbaik',
            
            'services' => [
                [
                    'title' => 'Alat Kesehatan',
                    'description' => 'Distribusi alat-alat kesehatan berkualitas tinggi dari berbagai merek terpercaya untuk mendukung operasional fasilitas kesehatan.',
                    'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                    'color' => 'emerald',
                ],
                [
                    'title' => 'Maintenance & Service',
                    'description' => 'Layanan perawatan dan perbaikan alat kesehatan oleh teknisi berpengalaman untuk menjaga performa optimal peralatan Anda.',
                    'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
                    'color' => 'teal',
                ],
                [
                    'title' => 'Suku Cadang',
                    'description' => 'Penyediaan suku cadang original dan berkualitas untuk berbagai jenis alat kesehatan dengan ketersediaan stok yang terjamin.',
                    'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    'color' => 'cyan',
                ],
                [
                    'title' => 'Training & Konsultasi',
                    'description' => 'Program pelatihan dan konsultasi untuk operator alat kesehatan guna meningkatkan kompetensi dan efisiensi penggunaan alat.',
                    'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                    'color' => 'green',
                ],
                [
                    'title' => 'Dokumentasi & Perizinan',
                    'description' => 'Bantuan pengurusan dokumentasi dan perizinan alat kesehatan sesuai dengan regulasi yang berlaku di Indonesia.',
                    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'color' => 'lime',
                ],
                [
                    'title' => 'Support 24/7',
                    'description' => 'Layanan dukungan teknis yang responsif dan tersedia kapan saja untuk membantu mengatasi permasalahan alat kesehatan Anda.',
                    'icon' => 'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z',
                    'color' => 'emerald',
                ],
            ],
            
            'parent_company_name' => 'PT Visi Yosindo Medikal',
            'parent_company_description' => 'Sebagai anak perusahaan, PT Sumpah Gajah Mada mendapat dukungan penuh dalam hal sumber daya, keahlian, dan jaringan dari PT Visi Yosindo Medikal',
            
            'benefits' => [
                [
                    'title' => 'Dukungan Penuh',
                    'description' => 'Akses ke sumber daya dan keahlian perusahaan induk',
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                ],
                [
                    'title' => 'Jaringan Luas',
                    'description' => 'Memanfaatkan jaringan distribusi yang sudah mapan',
                    'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                ],
                [
                    'title' => 'Pertumbuhan Bersama',
                    'description' => 'Sinergi untuk mencapai pertumbuhan yang berkelanjutan',
                    'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                ],
            ],
            
            'cta_title' => 'Tertarik Bekerja Sama?',
            'cta_subtitle' => 'Kami siap membantu Anda menemukan solusi terbaik untuk kebutuhan alat kesehatan dan layanan terkait. Hubungi tim kami sekarang!',
            'whatsapp_number' => '6281234567890',
        ]);
    }
}
