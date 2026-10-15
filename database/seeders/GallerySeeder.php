<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $eventCat = GalleryCategory::where('name', 'Event')->first();
        $productCat = GalleryCategory::where('name', 'Produk')->first();
        $officeCat = GalleryCategory::where('name', 'Kantor')->first();
        $trainingCat = GalleryCategory::where('name', 'Pelatihan')->first();

        $galleries = [
            ['category' => $eventCat, 'title' => 'Seminar Nasional Keselamatan Kerja', 'size' => 'col-span-2', 'order' => 1],
            ['category' => $eventCat, 'title' => 'Pameran Alat Keselamatan', 'size' => 'col-span-1', 'order' => 2],
            ['category' => $eventCat, 'title' => 'Workshop HSE', 'size' => 'col-span-1', 'order' => 3],
            ['category' => $productCat, 'title' => 'Safety Helmet Premium', 'size' => 'col-span-1', 'order' => 1],
            ['category' => $productCat, 'title' => 'Safety Shoes Collection', 'size' => 'col-span-2', 'order' => 2],
            ['category' => $productCat, 'title' => 'Protective Gloves', 'size' => 'col-span-1', 'order' => 3],
            ['category' => $officeCat, 'title' => 'Kantor Pusat Jakarta', 'size' => 'col-span-2', 'order' => 1],
            ['category' => $officeCat, 'title' => 'Gudang Distribusi', 'size' => 'col-span-1', 'order' => 2],
            ['category' => $trainingCat, 'title' => 'Pelatihan K3 Umum', 'size' => 'col-span-1', 'order' => 1],
            ['category' => $trainingCat, 'title' => 'Sertifikasi Ahli K3', 'size' => 'col-span-1', 'order' => 2],
        ];

        foreach ($galleries as $item) {
            Gallery::create([
                'gallery_category_id' => $item['category']->id,
                'title' => $item['title'],
                'description' => 'Dokumentasi ' . $item['title'],
                'image' => 'galleries/placeholder.jpg',
                'size' => $item['size'],
                'order' => $item['order'],
                'is_active' => true,
            ]);
        }
    }
}
