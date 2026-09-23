<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of published news posts.
     */
    public function index(Request $request)
    {
        $query = NewsPost::with('author')
            ->published()
            ->latest('published_at');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $posts = $query->paginate(12);
        $categories = NewsPost::published()
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();
        
        $featuredPosts = NewsPost::published()
            ->featured()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('pages.news.index', compact('posts', 'categories', 'featuredPosts'));
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
