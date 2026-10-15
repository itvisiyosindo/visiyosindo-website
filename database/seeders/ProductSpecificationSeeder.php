<?php

namespace Database\Seeders;

use App\Models\ProductContent;
use App\Models\ProductDetailContent;
use Illuminate\Database\Seeder;

class ProductSpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample specifications data for different product types
        $specificationsData = [
            [
                'Berat' => '5 kg',
                'Dimensi' => '30 x 40 x 20 cm',
                'Material' => 'Stainless Steel 304',
                'Kapasitas' => '100 liter',
                'Daya Listrik' => '220V / 50Hz',
                'Konsumsi Daya' => '1200 Watt',
                'Suhu Operasional' => '-5°C hingga 45°C',
                'Garansi' => '2 Tahun',
            ],
            [
                'Berat' => '3.5 kg',
                'Dimensi' => '25 x 35 x 15 cm',
                'Material' => 'Aluminium Anodized',
                'Kapasitas' => '50 liter',
                'Voltase' => '220V',
                'Frekuensi' => '50/60Hz',
                'Tingkat Kebisingan' => '< 60 dB',
                'Sertifikasi' => 'SNI, CE',
            ],
            [
                'Berat' => '8 kg',
                'Dimensi' => '45 x 50 x 30 cm',
                'Material' => 'Stainless Steel 316',
                'Kapasitas' => '200 liter',
                'Tekanan Maksimal' => '10 Bar',
                'Suhu Maksimal' => '100°C',
                'Filter' => 'HEPA Grade',
                'Standar' => 'ISO 9001:2015',
            ],
        ];

        // Get all products
        $products = ProductContent::with('detail')->get();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run product seeders first.');
            return;
        }

        $count = 0;
        foreach ($products as $product) {
            // Skip if product already has specifications
            if ($product->detail && $product->detail->specifications) {
                continue;
            }

            // Get random specifications
            $specs = $specificationsData[array_rand($specificationsData)];

            // Create or update product detail
            if ($product->detail) {
                $product->detail->update([
                    'specifications' => $specs,
                ]);
            } else {
                ProductDetailContent::create([
                    'product_content_id' => $product->id,
                    'specifications' => $specs,
                ]);
            }

            $count++;
        }

        $this->command->info("Added specifications to {$count} product(s).");
    }
}
