<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateCategory;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $categories = CertificateCategory::active()->ordered()->get();
        $certificates = Certificate::with(['category' => fn ($query) => $query->active()])
            ->whereHas('category', fn ($query) => $query->active())
            ->active()
            ->ordered()
            ->get();
        
        return view('pages.certificates', compact('categories', 'certificates'));
    }

    public function category($slug)
    {
        $category = CertificateCategory::where('slug', $slug)->active()->firstOrFail();
        $categories = CertificateCategory::active()->ordered()->get();
        $certificates = Certificate::with(['category' => fn ($query) => $query->active()])
            ->where('certificate_category_id', $category->id)
            ->whereHas('category', fn ($query) => $query->active())
            ->active()
            ->ordered()
            ->get();
        
        return view('pages.certificates', compact('categories', 'certificates', 'category'));
    }
}
