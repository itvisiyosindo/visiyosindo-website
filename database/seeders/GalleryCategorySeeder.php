<?php

namespace Database\Seeders;

use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Event', 'order' => 1],
            ['name' => 'Produk', 'order' => 2],
            ['name' => 'Kantor', 'order' => 3],
            ['name' => 'Pelatihan', 'order' => 4],
        ];

        foreach ($categories as $cat) {
            GalleryCategory::create([
                'name' => $cat['name'],
                'description' => 'Galeri ' . $cat['name'],
                'order' => $cat['order'],
                'is_active' => true,
            ]);
        }
    }
}
