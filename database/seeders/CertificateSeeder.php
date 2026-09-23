<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\CertificateCategory;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        $isoCat = CertificateCategory::where('name', 'ISO')->first();
        $govCat = CertificateCategory::where('name', 'Pemerintah')->first();
        $industryCat = CertificateCategory::where('name', 'Industri')->first();
        $trainingCat = CertificateCategory::where('name', 'Pelatihan')->first();

        $certificates = [
            ['category' => $isoCat, 'title' => 'ISO 9001:2015 Quality Management', 'issuer' => 'TUV Nord', 'cert_number' => 'ISO-9001-2024-001', 'valid' => '2027-12-31'],
            ['category' => $isoCat, 'title' => 'ISO 14001:2015 Environmental Management', 'issuer' => 'SGS', 'cert_number' => 'ISO-14001-2024-002', 'valid' => '2027-12-31'],
            ['category' => $isoCat, 'title' => 'ISO 45001:2018 Occupational Health & Safety', 'issuer' => 'Bureau Veritas', 'cert_number' => 'ISO-45001-2024-003', 'valid' => '2027-12-31'],
            ['category' => $govCat, 'title' => 'SIUP Perdagangan Besar', 'issuer' => 'Dinas Perindustrian', 'cert_number' => 'SIUP-2024-12345', 'valid' => '2029-12-31'],
            ['category' => $govCat, 'title' => 'TDP Terdaftar', 'issuer' => 'Dinas Perindustrian', 'cert_number' => 'TDP-2024-67890', 'valid' => '2029-12-31'],
            ['category' => $industryCat, 'title' => 'Distributor Resmi 3M Safety Products', 'issuer' => '3M Indonesia', 'cert_number' => '3M-DIST-2024-001', 'valid' => '2026-12-31'],
            ['category' => $industryCat, 'title' => 'Partner Resmi Honeywell Safety', 'issuer' => 'Honeywell', 'cert_number' => 'HW-PART-2024-002', 'valid' => '2026-12-31'],
            ['category' => $trainingCat, 'title' => 'Ahli K3 Umum', 'issuer' => 'Kemnaker RI', 'cert_number' => 'K3U-2024-001', 'valid' => '2027-12-31'],
            ['category' => $trainingCat, 'title' => 'Certified Safety Professional', 'issuer' => 'BCSP', 'cert_number' => 'CSP-2024-002', 'valid' => '2029-12-31'],
        ];

        foreach ($certificates as $item) {
            Certificate::create([
                'certificate_category_id' => $item['category']->id,
                'title' => $item['title'],
                'description' => 'Sertifikat ' . $item['title'],
                'image' => 'certificates/placeholder.jpg',
                'issuer' => $item['issuer'],
                'cert_number' => $item['cert_number'],
                'issued_date' => now()->subYear(),
                'valid_until' => $item['valid'],
                'status' => 'active',
                'order' => 1,
                'is_active' => true,
            ]);
        }
    }
}
