<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsPostController extends Controller
{
    /**
     * Display a listing of news posts.
     */
    public function index(Request $request)
    {
        $query = NewsPost::with('author')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        $posts = $query->paginate(15);
        $categories = NewsPost::distinct()->pluck('category')->filter()->sort()->values();

        return view('dashboard.news.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new news post.
     */
    public function create()
    {
        $categories = NewsPost::distinct()->pluck('category')->filter()->sort()->values();
        return view('dashboard.news.form', compact('categories'));
    }

    /**
     * Store a newly created news post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news_posts,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'canonical_url' => 'nullable|url|max:500',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('news/featured', 'public');
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('news/og-images', 'public');
        }

        // Process tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Process meta keywords
        if ($request->filled('meta_keywords')) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $request->meta_keywords));
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set author
        $validated['author_id'] = Auth::id();

        // Set published_at for published posts
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = NewsPost::create($validated);

        return redirect()
            ->route('dashboard.news.index')
            ->with('success', 'Berita berhasil dibuat!');
    }

    /**
     * Display the specified news post.
     */
    public function show(string $encryptedId)
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $post = NewsPost::with('author')->findOrFail($id);
        
        return view('dashboard.news.show', compact('post'));
    }

    /**
     * Show the form for editing the specified news post.
     */
    public function edit(string $encryptedId)
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $post = NewsPost::findOrFail($id);
        $categories = NewsPost::distinct()->pluck('category')->filter()->sort()->values();
        
        return view('dashboard.news.form', compact('post', 'categories'));
    }

    /**
     * Update the specified news post.
     */
    public function update(Request $request, string $encryptedId)
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $post = NewsPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:news_posts,slug,' . $id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'featured_image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'canonical_url' => 'nullable|url|max:500',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('news/featured', 'public');
        }

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            // Delete old image
            if ($post->og_image) {
                Storage::disk('public')->delete($post->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('news/og-images', 'public');
        }

        // Process tags
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        } else {
            $validated['tags'] = null;
        }

        // Process meta keywords
        if ($request->filled('meta_keywords')) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $request->meta_keywords));
        } else {
            $validated['meta_keywords'] = null;
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set published_at for published posts
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = $post->published_at ?? now();
        }

        $post->update($validated);

        return redirect()
            ->route('dashboard.news.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified news post.
     */
    public function destroy(string $encryptedId)
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $post = NewsPost::findOrFail($id);

        // Delete images
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        if ($post->og_image) {
            Storage::disk('public')->delete($post->og_image);
        }

        $post->delete();

        return redirect()
            ->route('dashboard.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Request $request, string $encryptedId)
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $post = NewsPost::findOrFail($id);
        
        $post->update(['is_featured' => !$post->is_featured]);

        return response()->json([
            'success' => true,
            'is_featured' => $post->is_featured,
            'message' => $post->is_featured ? 'Berita ditandai sebagai featured' : 'Berita dihapus dari featured'
        ]);
    }

    /**
     * Upload image for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:5120'
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('news/content-images', 'public');
            
            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
