<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = GalleryCategory::active()->ordered()->get();
        $galleries = Gallery::with('category')->active()->ordered()->get();
        
        return view('pages.gallery', compact('categories', 'galleries'));
    }

    public function category($slug)
    {
        $category = GalleryCategory::where('slug', $slug)->active()->firstOrFail();
        $categories = GalleryCategory::active()->ordered()->get();
        $galleries = Gallery::where('gallery_category_id', $category->id)
                            ->active()->ordered()->get();
        
        return view('pages.gallery', compact('categories', 'galleries', 'category'));
    }
}
