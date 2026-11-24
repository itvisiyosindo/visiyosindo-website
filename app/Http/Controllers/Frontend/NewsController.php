<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\NewsPost;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of published news posts.
     */
    public function index(Request $request)
    {
        NewsPost::syncVisiAcademyCategoryOnce();

        $query = NewsPost::with('author')
            ->published()
            ->latest('published_at');

        // Filter by category (case-insensitive so Event/event both match)
        if ($request->filled('category')) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($request->category)]);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $posts = $query->paginate(12)->withQueryString();

        $categories = NewsPost::availableCategories(publishedOnly: true);

        $featuredQuery = NewsPost::published()
            ->featured()
            ->latest('published_at');

        if ($request->filled('category')) {
            $featuredQuery->whereRaw('LOWER(category) = ?', [strtolower($request->category)]);
        }

        $featuredPosts = $featuredQuery->limit(3)->get();

        // Include Activity Documentation (Gallery) items when viewing Dokumentasi Event category
        $eventGalleries = collect();
        if (NewsPost::isEventCategory($request->category)) {
            try {
                $galleryQuery = Gallery::with('category')->active()->ordered();

                if ($request->filled('search')) {
                    $term = '%' . $request->search . '%';
                    $galleryQuery->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('description', 'like', $term);
                    });
                }

                $eventGalleries = $galleryQuery->get();
            } catch (\Throwable $e) {
                $eventGalleries = collect();
            }
        }

        return view('pages.news.index', compact('posts', 'categories', 'featuredPosts', 'eventGalleries'));
    }

    /**
     * Display the specified news post.
     */
    public function show(string $slug)
    {
        $post = NewsPost::with('author')
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Related posts (same category)
        $relatedPosts = NewsPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Recent posts
        $recentPosts = NewsPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(5)
            ->get();

        return view('pages.news.show', compact('post', 'relatedPosts', 'recentPosts'));
    }

    /**
     * Increment share count
     */
    public function share(string $slug)
    {
        $post = NewsPost::where('slug', $slug)->published()->firstOrFail();
        $post->incrementShares();

        return response()->json(['success' => true]);
    }
}
