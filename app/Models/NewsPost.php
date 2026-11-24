<?php

namespace App\Models;

use App\Helpers\EncryptedRouteHelper;
use App\Support\AcademySchemaEnsurer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class NewsPost extends Model
{
    use HasFactory, SoftDeletes;

    public const EVENT_CATEGORY = 'Dokumentasi Event';

    public const DEFAULT_CATEGORIES = ['Visi Academy', self::EVENT_CATEGORY];

    private static bool $visiAcademySynced = false;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'category',
        'tags',
        'author_id',
        'status',
        'published_at',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'views_count',
        'shares_count',
        'reading_time',
    ];

    protected $casts = [
        'tags' => 'array',
        'meta_keywords' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'shares_count' => 'integer',
        'reading_time' => 'integer',
    ];

    protected $appends = ['encrypted_id'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            
            // Calculate reading time (average reading speed: 200 words per minute)
            if ($post->content) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time = ceil($wordCount / 200);
            }

            // Auto-fill SEO fields if empty
            if (empty($post->meta_title)) {
                $post->meta_title = $post->title;
            }
            
            if (empty($post->meta_description) && $post->excerpt) {
                $post->meta_description = Str::limit(strip_tags($post->excerpt), 160);
            }
            
            if (empty($post->og_title)) {
                $post->og_title = $post->title;
            }
            
            if (empty($post->og_description) && $post->excerpt) {
                $post->og_description = Str::limit(strip_tags($post->excerpt), 200);
            }
        });

        static::updating(function ($post) {
            // Recalculate reading time on update
            if ($post->isDirty('content')) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time = ceil($wordCount / 200);
            }
        });
    }

    /**
     * Get encrypted ID for routes
     */
    public function getEncryptedIdAttribute(): string
    {
        return EncryptedRouteHelper::encrypt($this->id);
    }

    /**
     * Relationship: Author
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope: Published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope: Featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: By category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%");
        });
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Increment shares count
     */
    public function incrementShares()
    {
        $this->increment('shares_count');
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        if (!$this->published_at) {
            return null;
        }
        
        return $this->published_at->locale('id')->isoFormat('D MMMM YYYY');
    }

    /**
     * Get reading time text
     */
    public function getReadingTimeTextAttribute()
    {
        if (!$this->reading_time) {
            return null;
        }
        
        return $this->reading_time . ' menit baca';
    }

    /**
     * Check if post is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now();
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'published' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
            'draft' => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
            'scheduled' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'published' => 'Dipublikasikan',
            'draft' => 'Draft',
            'scheduled' => 'Terjadwal',
            default => 'Unknown',
        };
    }

    /**
     * One-time sync that assigns existing news mentioning "Visi Academy" to the "Visi Academy" category.
     * Tracked via academy_settings so subsequent manual category edits in admin panel are preserved.
     */
    public static function syncVisiAcademyCategoryOnce(): void
    {
        if (self::$visiAcademySynced) {
            return;
        }
        self::$visiAcademySynced = true;

        try {
            if (!Schema::hasTable('news_posts')) {
                return;
            }

            AcademySchemaEnsurer::ensure();

            $flagKey = 'news_visi_academy_synced_v1';
            $hasSettings = Schema::hasTable('academy_settings');

            if ($hasSettings && DB::table('academy_settings')->where('key', $flagKey)->exists()) {
                return;
            }

            static::where(function ($q) {
                $q->whereRaw('LOWER(title) LIKE ?', ['%visi academy%'])
                    ->orWhereRaw('LOWER(excerpt) LIKE ?', ['%visi academy%'])
                    ->orWhereRaw('LOWER(content) LIKE ?', ['%visi academy%']);
            })->where(function ($q) {
                $q->whereNull('category')
                    ->orWhereRaw("LOWER(TRIM(category)) != 'visi academy'");
            })->update(['category' => 'Visi Academy']);

            if ($hasSettings) {
                $now = now();
                DB::table('academy_settings')->insertOrIgnore([
                    'key' => $flagKey,
                    'value' => '1',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        } catch (\Throwable $e) {
            // Keep page rendering safely if DB lacks write permission during read request
        }
    }

    /**
     * Check whether a category value refers to the Event / Dokumentasi Event category.
     */
    public static function isEventCategory(?string $category): bool
    {
        return in_array(strtolower(trim((string) $category)), [strtolower(self::EVENT_CATEGORY), 'event'], true);
    }

    /**
     * Distinct categories including built-in defaults, with "Dokumentasi Event" always last (rightmost).
     */
    public static function availableCategories(bool $publishedOnly = false)
    {
        static::syncVisiAcademyCategoryOnce();

        $query = $publishedOnly ? static::published() : static::query();

        $categories = $query->distinct()->pluck('category')->filter()->values();

        foreach (self::DEFAULT_CATEGORIES as $defaultCategory) {
            if (!$categories->contains(fn ($cat) => strtolower((string) $cat) === strtolower($defaultCategory))) {
                $categories->push($defaultCategory);
            }
        }

        $eventKey = strtolower(self::EVENT_CATEGORY);
        $others = $categories
            ->reject(fn ($cat) => strtolower((string) $cat) === $eventKey)
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        return $others->push(self::EVENT_CATEGORY)->values();
    }
}
