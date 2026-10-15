<?php

namespace Database\Seeders;

use App\Models\CertificateCategory;
use Illuminate\Database\Seeder;

class CertificateCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'ISO', 'order' => 1],
            ['name' => 'Pemerintah', 'order' => 2],
            ['name' => 'Industri', 'order' => 3],
            ['name' => 'Pelatihan', 'order' => 4],
        ];

        foreach ($categories as $cat) {
            CertificateCategory::create([
                'name' => $cat['name'],
                'description' => 'Sertifikat ' . $cat['name'],
                'order' => $cat['order'],
                'is_active' => true,
            ]);
        }
    }
}
