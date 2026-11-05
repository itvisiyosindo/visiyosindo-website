<?php

use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\AnalyticsController;
use App\Http\Controllers\Dashboard\ApplicantController;
use App\Http\Controllers\Dashboard\CareerController;
use App\Http\Controllers\Dashboard\TopbarController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Admin\CertificateCategoryController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Dashboard\CompanyInfoController;
use App\Http\Controllers\Dashboard\ContactSubmissionController;
use App\Http\Controllers\Dashboard\DirectorMessageController;
use App\Http\Controllers\Dashboard\HeroSlideController;
use App\Http\Controllers\Dashboard\HomeIntroductionController;
use App\Http\Controllers\Dashboard\VisionMissionController;
use App\Http\Controllers\Dashboard\MapMarkerController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\Dashboard\VisilabPageController;
use App\Http\Controllers\Dashboard\NewsPostController;
use App\Http\Controllers\Dashboard\OfficeLocationController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\ProductCategoryController;
use App\Http\Controllers\Dashboard\ProductContentController;
use App\Http\Controllers\Dashboard\PromoBannerController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\UserRoleController;
use App\Http\Controllers\Dashboard\UserManagementController;
use App\Http\Controllers\Frontend\CareerController as FrontendCareerController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\TeamController as FrontendTeamController;
use App\Http\Controllers\Frontend\VisilabController;
use App\Http\Controllers\OgImageController;
use App\Http\Controllers\SitemapController;
use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\HomeIntroduction;
use App\Models\NewsPost;
use App\Models\OfficeLocation;
use App\Models\PromoBanner;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| SEO Routes (with rate limiting for security)
|--------------------------------------------------------------------------
*/

Route::middleware(['throttle:60,1'])->group(function () {
    // OG Image generation - rate limited to prevent abuse
    Route::get('/og-image', [OgImageController::class, 'generate'])->name('og-image');
    Route::get('/og-image.svg', [OgImageController::class, 'generateSvg'])->name('og-image.svg');
});

// Sitemap doesn't need rate limiting as it's cached
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Digital Radiography clinical sample images route
Route::get('/assets/images/radiography-samples/{filename}', function (string $filename) {
    $filename = basename($filename);
    $paths = [
        base_path('public/assets/images/radiography-samples/' . $filename),
        public_path('assets/images/radiography-samples/' . $filename),
        storage_path('app/public/radiography-samples/' . $filename),
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            return response()->file($path, [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }
    }

    abort(404);
});

// Promo & Visilab Flyer images route (guarantees flyers always load 200 OK)
Route::get('/assets/images/flyers/{filename}', function (string $filename) {
    $filename = basename($filename);
    $paths = [
        base_path('public/assets/images/flyers/' . $filename),
        public_path('assets/images/flyers/' . $filename),
        storage_path('app/public/flyers/' . $filename),
        base_path('public/images/flyers/' . $filename),
        public_path('images/flyers/' . $filename),
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            return response()->file($path, [
                'Content-Type' => str_ends_with(strtolower($filename), '.png') ? 'image/png' : 'image/jpeg',
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }
    }

    abort(404);
});

Route::get('/storage/flyers/{filename}', function (string $filename) {
    $filename = basename($filename);
    $paths = [
        storage_path('app/public/flyers/' . $filename),
        base_path('public/assets/images/flyers/' . $filename),
        public_path('assets/images/flyers/' . $filename),
        base_path('public/images/flyers/' . $filename),
        public_path('images/flyers/' . $filename),
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            return response()->file($path, [
                'Content-Type' => str_ends_with(strtolower($filename), '.png') ? 'image/png' : 'image/jpeg',
                'Cache-Control' => 'public, max-age=31536000',
            ]);
        }
    }

    return redirect()->to(url('/assets/images/flyers/' . $filename));
});

Route::get('/images/flyers/{filename}', function (string $filename) {
    return redirect()->to(url('/assets/images/flyers/' . basename($filename)));
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Public Routes (Frontend)
|--------------------------------------------------------------------------
*/
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'], true)) {
        session(['locale' => $locale]);
        cookie()->queue(cookie()->make('locale', $locale, 60 * 24 * 365, '/', null, false, false));

        $gtValue = $locale === 'en' ? '/id/en' : '/id/id';
        cookie()->queue(cookie()->make('googtrans', $gtValue, 60 * 24 * 365, '/', null, false, false));
    }
    return redirect()->back(fallback: route('home'));
})->name('set-locale');

Route::get('/', function () {
    // Get active hero slides and prepare for JavaScript
    $heroSlides = \App\Models\HeroSlide::where('is_active', true)
        ->orderBy('display_order')
        ->get()
        ->map(function($slide) {
            return [
                'image' => Storage::url($slide->image_path),
                'description' => __($slide->description ?? ''),
                'title' => __($slide->title ?? ''),
                'button_text' => __($slide->button_text ?? ''),
                'button_url' => $slide->button_url ?? '#'
            ];
        });
    
    // Fallback to default slide if empty
    if ($heroSlides->isEmpty()) {
        $heroSlides = collect([
            [
                'image' => asset('assets/carousel/slider-default-1.png'),
                'description' => __('Distributor resmi peralatan radiologi dengan teknologi pencitraan presisi tinggi'),
                'title' => __('Solusi Radiologi Terpercaya'),
                'button_text' => '',
                'button_url' => '#'
            ]
        ]);
    }
    
    // Ensure the 3 latest official flyers are active in the database
    try {
        $hasBatch6 = PromoBanner::where('title', 'like', '%Batch 6%')->exists();
        if (! $hasBatch6) {
            PromoBanner::where('is_active', true)->update(['is_active' => false]);
            PromoBanner::create([
                'title' => 'Open Registration PPR Medik TK II - Batch 6',
                'label' => 'Open Registration Batch 6',
                'description' => 'Ikuti pelatihan bersama Visi Academy! Jadwal Pelatihan: 2-6 Des 2026, Ujian SIB: 7-8 Des 2026 di VISILAB Pekanbaru. Promo diskon 10%.',
                'image_path' => 'assets/images/flyers/ppr-batch-6.jpg',
                'link_url' => 'https://visiyosindo.id/PendaftaranPelatihanPetugasProteksiRadiasiMedikTKII',
                'button_text' => 'Daftar Batch 6',
                'display_order' => 1,
                'is_active' => true,
            ]);
            PromoBanner::create([
                'title' => 'Visi Academy Membership - Bayar Sekali, Nikmati 1 Tahun Penuh!',
                'label' => 'Program Keanggotaan',
                'description' => 'Hanya Rp100.000/tahun. Nikmati diskon webinar 10%, diskon pelatihan PPR 10%, diskon Training Center 20%, reward referral 10%.',
                'image_path' => 'assets/images/flyers/membership-visilab-academy.jpg',
                'link_url' => 'https://forms.gle/kNpBp9LCQF5yLDWz7',
                'button_text' => 'Daftar Membership',
                'display_order' => 2,
                'is_active' => true,
            ]);
            PromoBanner::create([
                'title' => 'Visilab Calibration Care+: Program Kontrak Kalibrasi Alat X-Ray',
                'label' => 'Program Kontrak Khusus',
                'description' => 'Layanan kalibrasi selama 3 periode layanan, berkesempatan memperoleh UPAR + gratis 1 kali kalibrasi pada periode tahun ke-4.',
                'image_path' => 'assets/images/flyers/calibration-care.jpg',
                'link_url' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                'button_text' => 'Konsultasi Care+',
                'display_order' => 3,
                'is_active' => true,
            ]);
        }
    } catch (\Throwable $e) {
        // Silently continue
    }

    // Get active promo banners or fallback to 3 official active flyers
    $dbPromoBanners = PromoBanner::where('is_active', true)
        ->orderBy('display_order')
        ->get();

    if ($dbPromoBanners->isNotEmpty()) {
        $promoBanners = $dbPromoBanners->map(function($banner, $idx) {
            $isPpr = str_contains(strtolower($banner->title ?? ''), 'ppr') || str_contains(strtolower($banner->title ?? ''), 'radiasi') || str_contains(strtolower($banner->title ?? ''), 'batch 6');
            $isMember = str_contains(strtolower($banner->title ?? ''), 'member');
            $isCalib = str_contains(strtolower($banner->title ?? ''), 'kalibrasi') || str_contains(strtolower($banner->title ?? ''), 'care');

            if ($isPpr) {
                $stubMonth = 'Pelatihan';
                $stubDay = '02-06';
                $stubYear = 'DES 2026';
                $stubLocation = 'PEKANBARU';
                $badge = 'SIB MEDIK TK II';
                $highlights = [
                    '📅 Ujian SIB: 07 - 08 Des 2026',
                    '📍 VISILAB Pekanbaru',
                    '🎓 Biaya: Rp6.000.000',
                    '🎁 Promo Diskon 10%',
                    '📲 Kuota Terbatas',
                ];
            } elseif ($isMember) {
                $stubMonth = 'Membership';
                $stubDay = '1 TAHUN';
                $stubYear = '2026';
                $stubLocation = 'VISI ACADEMY';
                $badge = 'ALL ACCESS PASS';
                $highlights = [
                    '💰 Hanya Rp100.000/tahun',
                    '🎓 Diskon Webinar SKP 10%',
                    '⚡ Diskon Pelatihan PPR 10%',
                    '🏥 Training Center Diskon 20%',
                    '🎁 Referral Reward Hingga 10%',
                ];
            } elseif ($isCalib) {
                $stubMonth = 'KONTRAK RESMI';
                $stubDay = '3 TAHUN';
                $stubYear = '2026';
                $stubLocation = 'VISILAB CARE+';
                $badge = 'STANDAR BAPETEN';
                $highlights = [
                    '🏥 Mobile, Portable & Stationary X-Ray',
                    '🎁 Gratis 1x Kalibrasi + UPAR Thn ke-4',
                    '📋 Kontrak 3 Periode Layanan',
                    '🛡️ Jaminan Standar BAPETEN',
                ];
            } else {
                $stubMonth = 'PROMO';
                $stubDay = '2026';
                $stubYear = '2026';
                $stubLocation = 'OFFICIAL';
                $badge = 'PROMO RESMI';
                $highlights = array_filter([$banner->description ? Str::limit($banner->description, 35) : null, '📍 Pekanbaru', '📲 Kuota Terbatas']);
            }

            $imagePath = $banner->image_path ?? '';
            $basename = basename($imagePath);
            $lowerTitle = strtolower($banner->title ?? '');

            if (str_contains($lowerTitle, 'kalibrasi') || str_contains($lowerTitle, 'care') || str_contains(strtolower($basename), 'calibration')) {
                $resolvedImage = url('/assets/images/flyers/calibration-care.jpg');
            } elseif (str_contains($lowerTitle, 'member') || str_contains(strtolower($basename), 'membership')) {
                $resolvedImage = url('/assets/images/flyers/membership-visilab-academy.jpg');
            } elseif (str_contains($lowerTitle, 'ppr') || str_contains($lowerTitle, 'radiasi') || str_contains($lowerTitle, 'batch') || str_contains(strtolower($basename), 'ppr')) {
                $resolvedImage = url('/assets/images/flyers/ppr-batch-6.jpg');
            } elseif (str_starts_with($imagePath, 'http')) {
                $resolvedImage = $imagePath;
            } elseif (str_starts_with($imagePath, 'assets/')) {
                $resolvedImage = asset($imagePath);
            } else {
                $resolvedImage = url('/assets/images/flyers/' . $basename);
            }

            return [
                'stub_month' => $stubMonth,
                'stub_day' => $stubDay,
                'stub_year' => $stubYear,
                'stub_location' => $stubLocation,
                'badge' => $badge,
                'label' => __($banner->label ?? ($isPpr ? 'Open Registration Batch 6' : ($isMember ? 'Program Keanggotaan' : ($isCalib ? 'Program Kontrak Khusus' : 'Agenda Resmi')))),
                'title' => __($banner->title ?? ''),
                'description' => __($banner->description ?? ''),
                'highlights' => $highlights,
                'buttonText' => __($banner->button_text ?? ($isPpr ? 'Daftar Batch 6' : ($isMember ? 'Daftar Membership' : ($isCalib ? 'Konsultasi Care+' : 'Lihat Detail')))),
                'link' => $banner->link_url ?? '#',
                'contactText' => 'Info WA: 0895-0724-0145',
                'contactLink' => 'https://wa.me/6289507240145',
                'bgClass' => 'bg-linear-to-r from-blue-600 to-cyan-600',
                'image' => $resolvedImage
            ];
        });
    } else {
        $promoBanners = collect([
            [
                'stub_month' => 'Pelatihan',
                'stub_day' => '02-06',
                'stub_year' => 'DES 2026',
                'stub_location' => 'PEKANBARU',
                'badge' => 'SIB MEDIK TK II',
                'label' => __('Open Registration Batch 6'),
                'title' => __('Open Registration PPR Medik TK II - Batch 6'),
                'description' => __('Ikuti pelatihan bersama Visi Academy! Pembelajaran teori, praktik langsung di RS, serta simulasi ujian tertulis, praktik & wawancara.'),
                'highlights' => [
                    '📅 Ujian SIB: 07 - 08 Des 2026',
                    '📍 VISILAB Pekanbaru',
                    '🎓 Biaya: Rp6.000.000',
                    '🎁 Promo Diskon 10%',
                    '📲 Kuota Terbatas',
                ],
                'buttonText' => __('Daftar Batch 6'),
                'link' => 'https://visiyosindo.id/PendaftaranPelatihanPetugasProteksiRadiasiMedikTKII',
                'contactText' => 'Info WA: 0895-0724-0145',
                'contactLink' => 'https://wa.me/6289507240145',
                'bgClass' => 'bg-linear-to-r from-blue-600 to-cyan-600',
                'image' => url('/assets/images/flyers/ppr-batch-6.jpg'),
            ],
            [
                'stub_month' => 'Membership',
                'stub_day' => '1 TAHUN',
                'stub_year' => '2026',
                'stub_location' => 'VISI ACADEMY',
                'badge' => 'ALL ACCESS PASS',
                'label' => __('Program Keanggotaan'),
                'title' => __('Visi Academy Membership - Bayar Sekali, Nikmati 1 Tahun Penuh!'),
                'description' => __('Ingin lebih hemat saat mengikuti webinar, pelatihan, dan kegiatan Visi Academy? Cukup bayar 1 kali Rp100.000/tahun.'),
                'highlights' => [
                    '💰 Hanya Rp100.000/tahun',
                    '🎓 Diskon Webinar SKP 10%',
                    '⚡ Diskon Pelatihan PPR 10%',
                    '🏥 Training Center Diskon 20%',
                    '🎁 Referral Reward Hingga 10%',
                ],
                'buttonText' => __('Daftar Membership'),
                'link' => 'https://forms.gle/kNpBp9LCQF5yLDWz7',
                'contactText' => 'Info WA: 0895-0724-0145',
                'contactLink' => 'https://wa.me/6289507240145',
                'bgClass' => 'bg-linear-to-r from-purple-600 to-pink-600',
                'image' => url('/assets/images/flyers/membership-visilab-academy.jpg'),
            ],
            [
                'stub_month' => 'KONTRAK RESMI',
                'stub_day' => '3 TAHUN',
                'stub_year' => '2026',
                'stub_location' => 'VISILAB CARE+',
                'badge' => 'STANDAR BAPETEN',
                'label' => __('Program Kontrak Khusus'),
                'title' => __('Visilab Calibration Care+: Program Kontrak Kalibrasi Alat X-Ray'),
                'description' => __('Layanan kalibrasi selama 3 periode layanan, sekaligus berkesempatan memperoleh UPAR + gratis 1 kali kalibrasi pada periode tahun ke-4.'),
                'highlights' => [
                    '🏥 Mobile, Portable & Stationary X-Ray',
                    '🎁 Gratis 1x Kalibrasi + UPAR Thn ke-4',
                    '📋 Kontrak 3 Periode Layanan',
                    '🛡️ Jaminan Standar BAPETEN',
                ],
                'buttonText' => __('Konsultasi Care+'),
                'link' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                'contactText' => 'Info WA: 0895-0724-0145',
                'contactLink' => 'https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20dengan%20program%20Visilab%20Calibration%20Care%2B',
                'bgClass' => 'bg-linear-to-r from-cyan-600 to-blue-600',
                'image' => url('/assets/images/flyers/calibration-care.jpg'),
            ],
        ]);
    }
    
    // Get active home introduction
    $introduction = \App\Models\HomeIntroduction::where('is_active', true)
        ->first();
    
    // Get active office locations
    $offices = \App\Models\OfficeLocation::where('is_active', true)
        ->orderBy('display_order')
        ->get();
    
    // Get 5 latest gallery images
    $galleries = \App\Models\Gallery::with('category')
        ->where('is_active', true)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
    
    // Get 5 latest published news
    $news = \App\Models\NewsPost::where('status', 'published')
        ->where('published_at', '<=', now())
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();
    
    return view('home', compact('heroSlides', 'promoBanners', 'introduction', 'offices', 'galleries', 'news'));
})->name('home');

Route::get('/gallery', [\App\Http\Controllers\Frontend\GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [\App\Http\Controllers\Frontend\GalleryController::class, 'category'])->name('gallery.category');

Route::get('/news', [\App\Http\Controllers\Frontend\NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [\App\Http\Controllers\Frontend\NewsController::class, 'show'])->name('news.detail');
Route::post('/news/{slug}/share', [\App\Http\Controllers\Frontend\NewsController::class, 'share'])->name('news.share');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

Route::get('/our-team', [FrontendTeamController::class, 'index'])->name('our-team');

Route::get('/our-partners', [\App\Http\Controllers\Frontend\PartnerController::class, 'index'])->name('our-partners');

Route::get('/certificates', [\App\Http\Controllers\Frontend\CertificateController::class, 'index'])->name('certificates');
Route::get('/certificates/{slug}', [\App\Http\Controllers\Frontend\CertificateController::class, 'category'])->name('certificates.category');

Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('product.detail');

Route::get('/career', [FrontendCareerController::class, 'index'])->name('karir');

Route::get('/karir/{slug}', [FrontendCareerController::class, 'show'])->name('karir.detail');

Route::post('/career/apply', [FrontendCareerController::class, 'apply'])->name('career.apply');

/*
|--------------------------------------------------------------------------
| Visilab Routes
|--------------------------------------------------------------------------
*/
Route::get('/visilab/uji-kesesuaian', [VisilabController::class, 'ujiKesesuaian'])->name('visilab.uji-kesesuaian');
Route::get('/visilab/uji-paparan', [VisilabController::class, 'ujiPaparan'])->name('visilab.uji-paparan');
Route::get('/visilab/uji-kalibrasi', [VisilabController::class, 'ujiKalibrasi'])->name('visilab.uji-kalibrasi');
Route::get('/visilab/ppr', [VisilabController::class, 'ppr'])->name('visilab.ppr');

Route::get('/sgm', [\App\Http\Controllers\Dashboard\SgmPageController::class, 'show'])->name('sgm');

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Topbar APIs (Search + Notifications)
    Route::prefix('dashboard/topbar')->name('dashboard.topbar.')->group(function () {
        Route::get('/search', [TopbarController::class, 'search'])->name('search');

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [TopbarController::class, 'notifications'])->name('index');
            Route::post('/mark-all-read', [TopbarController::class, 'markAllNotificationsRead'])->name('mark-all-read');
            Route::post('/{notification}/mark-read', [TopbarController::class, 'markNotificationRead'])->name('mark-read');
        });
    });

    // Self account management
    Route::prefix('dashboard/account')->name('dashboard.account.')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('password.update');

        Route::get('/settings', [AccountController::class, 'settings'])->name('settings');
        Route::put('/settings', [AccountController::class, 'updateSettings'])->name('settings.update');
    });

    // Dashboard - requires view-dashboard permission
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('permission:view-dashboard');

    // Product Content Management
    Route::prefix('dashboard/products')->name('dashboard.products.')->group(function () {
        // View products
        Route::get('/', [ProductContentController::class, 'index'])->name('index')->middleware('permission:view-products');

        // Create products
        Route::get('/create', [ProductContentController::class, 'create'])->name('create')->middleware('permission:create-products');
        Route::post('/', [ProductContentController::class, 'store'])->name('store')->middleware('permission:create-products');

        // Product Categories - must be before {encryptedId} route
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [ProductCategoryController::class, 'index'])->name('index')->middleware('permission:view-product-categories');
            Route::get('/create', [ProductCategoryController::class, 'create'])->name('create')->middleware('permission:create-product-categories');
            Route::post('/', [ProductCategoryController::class, 'store'])->name('store')->middleware('permission:create-product-categories');
            Route::get('/{encryptedId}/edit', [ProductCategoryController::class, 'edit'])->name('edit')->middleware('permission:edit-product-categories');
            Route::put('/{encryptedId}', [ProductCategoryController::class, 'update'])->name('update')->middleware('permission:edit-product-categories');
            Route::delete('/{encryptedId}', [ProductCategoryController::class, 'destroy'])->name('destroy')->middleware('permission:delete-product-categories');
            Route::post('/{encryptedId}/toggle-status', [ProductCategoryController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-product-categories');
        });

        // Prevent static segments (create/categories) from being treated as encrypted IDs.
        Route::get('/{encryptedId}', [ProductContentController::class, 'show'])
            ->where('encryptedId', '(?!create$|categories$)[^/]+')
            ->name('show')
            ->middleware('permission:view-products');

        // Edit products
        Route::get('/{encryptedId}/edit', [ProductContentController::class, 'edit'])
            ->where('encryptedId', '(?!create$|categories$)[^/]+')
            ->name('edit')
            ->middleware('permission:edit-products');
        Route::put('/{encryptedId}', [ProductContentController::class, 'update'])
            ->where('encryptedId', '(?!create$|categories$)[^/]+')
            ->name('update')
            ->middleware('permission:edit-products');
        Route::post('/{encryptedId}/toggle-status', [ProductContentController::class, 'toggleStatus'])
            ->where('encryptedId', '(?!create$|categories$)[^/]+')
            ->name('toggle-status')
            ->middleware('permission:edit-products');

        // Delete products
        Route::delete('/{encryptedId}', [ProductContentController::class, 'destroy'])
            ->where('encryptedId', '(?!create$|categories$)[^/]+')
            ->name('destroy')
            ->middleware('permission:delete-products');
        Route::delete('/images/{encryptedId}', [ProductContentController::class, 'deleteImage'])->name('delete-image')->middleware('permission:edit-products');
        
        // Image Enhancement (requires edit permission)
        Route::post('/images/analyze', [ProductContentController::class, 'analyzeImage'])->name('analyze-image')->middleware('permission:edit-products');
        Route::post('/images/enhance', [ProductContentController::class, 'enhanceImage'])->name('enhance-image')->middleware('permission:edit-products');
        Route::post('/images/preview-enhancement', [ProductContentController::class, 'previewEnhancement'])->name('preview-enhancement')->middleware('permission:edit-products');
    });

    // Career Management
    Route::prefix('dashboard/careers')->name('dashboard.careers.')->group(function () {
        Route::get('/', [CareerController::class, 'index'])->name('index')->middleware('permission:view-careers');
        Route::get('/create', [CareerController::class, 'create'])->name('create')->middleware('permission:create-careers');
        Route::post('/', [CareerController::class, 'store'])->name('store')->middleware('permission:create-careers');
        Route::get('/{encryptedId}/edit', [CareerController::class, 'edit'])->name('edit')->middleware('permission:edit-careers');
        Route::put('/{encryptedId}', [CareerController::class, 'update'])->name('update')->middleware('permission:edit-careers');
        Route::post('/{encryptedId}/toggle-status', [CareerController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-careers');
        Route::delete('/{encryptedId}', [CareerController::class, 'destroy'])->name('destroy')->middleware('permission:delete-careers');

        // Applicants per vacancy
        Route::prefix('/{encryptedVacancyId}/applicants')->name('applicants.')->group(function () {
            Route::get('/', [ApplicantController::class, 'index'])->name('index')->middleware('permission:view-applicants');
            Route::get('/{encryptedId}', [ApplicantController::class, 'show'])->name('show')->middleware('permission:view-applicants');
            Route::post('/{encryptedId}/status', [ApplicantController::class, 'updateStatus'])->name('update-status')->middleware('permission:screen-applicants');
            Route::delete('/{encryptedId}', [ApplicantController::class, 'destroy'])->name('destroy')->middleware('permission:delete-applicants');
            Route::get('/{encryptedId}/preview/{type}', [ApplicantController::class, 'previewDocument'])->name('preview')->middleware('permission:view-applicants');
            Route::get('/{encryptedId}/download/{type}', [ApplicantController::class, 'downloadDocument'])->name('download')->middleware('permission:view-applicants');
        });
    });

    // Team Management
    Route::prefix('dashboard/teams')->name('dashboard.teams.')->group(function () {
        Route::get('/', [TeamController::class, 'index'])->name('index')->middleware('permission:view-teams');
        Route::get('/create', [TeamController::class, 'create'])->name('create')->middleware('permission:create-teams');
        Route::post('/', [TeamController::class, 'store'])->name('store')->middleware('permission:create-teams');
        Route::get('/{encryptedId}/edit', [TeamController::class, 'edit'])->name('edit')->middleware('permission:edit-teams');
        Route::put('/{encryptedId}', [TeamController::class, 'update'])->name('update')->middleware('permission:edit-teams');
        Route::post('/{encryptedId}/toggle-status', [TeamController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-teams');
        Route::delete('/{encryptedId}', [TeamController::class, 'destroy'])->name('destroy')->middleware('permission:delete-teams');
    });

    // Company Info Management (About Us Page Content)
    Route::prefix('dashboard/company-info')->name('dashboard.company-info.')->group(function () {
        Route::get('/edit', [CompanyInfoController::class, 'edit'])->name('edit')->middleware('permission:view-company-info');
        Route::put('/update', [CompanyInfoController::class, 'update'])->name('update')->middleware('permission:edit-company-info');
    });

    // Vision & Mission Management
    Route::prefix('dashboard/vision-mission')->name('dashboard.vision-mission.')->group(function () {
        Route::get('/', [VisionMissionController::class, 'index'])->name('index')->middleware('permission:view-vision-mission');
        Route::put('/update', [VisionMissionController::class, 'update'])->name('update')->middleware('permission:edit-vision-mission');
    });

    // Map Markers Management
    Route::prefix('dashboard/map-markers')->name('dashboard.map-markers.')->group(function () {
        Route::get('/', [MapMarkerController::class, 'index'])->name('index')->middleware('permission:view-map-markers');
        Route::get('/create', [MapMarkerController::class, 'create'])->name('create')->middleware('permission:create-map-markers');
        Route::post('/', [MapMarkerController::class, 'store'])->name('store')->middleware('permission:create-map-markers');
        Route::get('/{encryptedId}/edit', [MapMarkerController::class, 'edit'])->name('edit')->middleware('permission:edit-map-markers');
        Route::put('/{encryptedId}', [MapMarkerController::class, 'update'])->name('update')->middleware('permission:edit-map-markers');
        Route::post('/{encryptedId}/toggle-status', [MapMarkerController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-map-markers');
        Route::delete('/{encryptedId}', [MapMarkerController::class, 'destroy'])->name('destroy')->middleware('permission:delete-map-markers');
    });

    // Testimonials Management
    Route::prefix('dashboard/testimonials')->name('dashboard.testimonials.')->group(function () {
        Route::get('/', [TestimonialController::class, 'index'])->name('index')->middleware('permission:view-testimonials');
        Route::get('/create', [TestimonialController::class, 'create'])->name('create')->middleware('permission:create-testimonials');
        Route::post('/', [TestimonialController::class, 'store'])->name('store')->middleware('permission:create-testimonials');
        Route::get('/{encryptedId}/edit', [TestimonialController::class, 'edit'])->name('edit')->middleware('permission:edit-testimonials');
        Route::put('/{encryptedId}', [TestimonialController::class, 'update'])->name('update')->middleware('permission:edit-testimonials');
        Route::post('/{encryptedId}/toggle-status', [TestimonialController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-testimonials');
        Route::delete('/{encryptedId}', [TestimonialController::class, 'destroy'])->name('destroy')->middleware('permission:delete-testimonials');
    });

    // Visilab Pages Management
    Route::prefix('dashboard/visilab-pages')->name('dashboard.visilab-pages.')->group(function () {
        Route::get('/', [VisilabPageController::class, 'index'])->name('index')->middleware('permission:view-visilab-pages');
        Route::get('/{slug}/edit', [VisilabPageController::class, 'edit'])->name('edit')->middleware('permission:edit-visilab-pages');
        Route::put('/{slug}', [VisilabPageController::class, 'update'])->name('update')->middleware('permission:edit-visilab-pages');
        Route::post('/{slug}/toggle-status', [VisilabPageController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-visilab-pages');
    });

    // SGM Page Management
    Route::prefix('dashboard/sgm-page')->name('dashboard.sgm-page.')->group(function () {
        Route::get('/edit', [\App\Http\Controllers\Dashboard\SgmPageController::class, 'edit'])->name('edit')->middleware('permission:view-sgm-page');
        Route::put('/update', [\App\Http\Controllers\Dashboard\SgmPageController::class, 'update'])->name('update')->middleware('permission:edit-sgm-page');
    });

    // Director Message Management
    Route::prefix('dashboard/director')->name('dashboard.director.')->group(function () {
        Route::get('/', [DirectorMessageController::class, 'index'])->name('index')->middleware('permission:view-director-messages');
        Route::get('/create', [DirectorMessageController::class, 'create'])->name('create')->middleware('permission:create-director-messages');
        Route::post('/', [DirectorMessageController::class, 'store'])->name('store')->middleware('permission:create-director-messages');
        Route::get('/{encryptedId}/edit', [DirectorMessageController::class, 'edit'])->name('edit')->middleware('permission:edit-director-messages');
        Route::put('/{encryptedId}', [DirectorMessageController::class, 'update'])->name('update')->middleware('permission:edit-director-messages');
        Route::post('/{encryptedId}/toggle-status', [DirectorMessageController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-director-messages');
        Route::delete('/{encryptedId}', [DirectorMessageController::class, 'destroy'])->name('destroy')->middleware('permission:delete-director-messages');
    });

    // News & Updates Management
    Route::prefix('dashboard/news')->name('dashboard.news.')->group(function () {
        Route::get('/', [NewsPostController::class, 'index'])->name('index')->middleware('permission:view-news');
        Route::get('/create', [NewsPostController::class, 'create'])->name('create')->middleware('permission:create-news');
        Route::get('/{encryptedId}', [NewsPostController::class, 'show'])->name('show')->middleware('permission:view-news');
        Route::post('/', [NewsPostController::class, 'store'])->name('store')->middleware('permission:create-news');
        Route::post('/upload-image', [NewsPostController::class, 'uploadImage'])->name('upload-image')->middleware('permission:create-news');
        Route::get('/{encryptedId}/edit', [NewsPostController::class, 'edit'])->name('edit')->middleware('permission:edit-news');
        Route::put('/{encryptedId}', [NewsPostController::class, 'update'])->name('update')->middleware('permission:edit-news');
        Route::post('/{encryptedId}/toggle-featured', [NewsPostController::class, 'toggleFeatured'])->name('toggle-featured')->middleware('permission:edit-news');
        Route::delete('/{encryptedId}', [NewsPostController::class, 'destroy'])->name('destroy')->middleware('permission:delete-news');
    });

    // Analytics Dashboard
    Route::prefix('dashboard/analytics')->name('dashboard.analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index')->middleware('permission:view-analytics');
        Route::get('/chart-data', [AnalyticsController::class, 'getChartData'])->name('chart-data')->middleware('permission:view-analytics');
    });

    // Partners Management
    Route::prefix('dashboard/partners')->name('dashboard.partners.')->group(function () {
        Route::get('/', [PartnerController::class, 'index'])->name('index')->middleware('permission:view-partners');
        Route::get('/create', [PartnerController::class, 'create'])->name('create')->middleware('permission:create-partners');
        Route::post('/', [PartnerController::class, 'store'])->name('store')->middleware('permission:create-partners');
        Route::get('/{encryptedId}/edit', [PartnerController::class, 'edit'])->name('edit')->middleware('permission:edit-partners');
        Route::put('/{encryptedId}', [PartnerController::class, 'update'])->name('update')->middleware('permission:edit-partners');
        Route::delete('/{encryptedId}', [PartnerController::class, 'destroy'])->name('destroy')->middleware('permission:delete-partners');
    });

    // Clients Management
    Route::prefix('dashboard/clients')->name('dashboard.clients.')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index')->middleware('permission:view-partners');
        Route::get('/create', [ClientController::class, 'create'])->name('create')->middleware('permission:create-partners');
        Route::post('/', [ClientController::class, 'store'])->name('store')->middleware('permission:create-partners');
        Route::get('/{encryptedId}/edit', [ClientController::class, 'edit'])->name('edit')->middleware('permission:edit-partners');
        Route::put('/{encryptedId}', [ClientController::class, 'update'])->name('update')->middleware('permission:edit-partners');
        Route::delete('/{encryptedId}', [ClientController::class, 'destroy'])->name('destroy')->middleware('permission:delete-partners');
    });

    // Hero Slides Management
    Route::prefix('dashboard/hero-slides')->name('dashboard.hero-slides.')->group(function () {
        Route::get('/', [HeroSlideController::class, 'index'])->name('index')->middleware('permission:view-hero-slides');
        Route::get('/create', [HeroSlideController::class, 'create'])->name('create')->middleware('permission:create-hero-slides');
        Route::post('/', [HeroSlideController::class, 'store'])->name('store')->middleware('permission:create-hero-slides');
        Route::get('/{encryptedId}/edit', [HeroSlideController::class, 'edit'])->name('edit')->middleware('permission:edit-hero-slides');
        Route::put('/{encryptedId}', [HeroSlideController::class, 'update'])->name('update')->middleware('permission:edit-hero-slides');
        Route::delete('/{encryptedId}', [HeroSlideController::class, 'destroy'])->name('destroy')->middleware('permission:delete-hero-slides');
    });

    // Promo Banners Management
    Route::prefix('dashboard/promo-banners')->name('dashboard.promo-banners.')->group(function () {
        Route::get('/', [PromoBannerController::class, 'index'])->name('index')->middleware('permission:view-promo-banners');
        Route::get('/create', [PromoBannerController::class, 'create'])->name('create')->middleware('permission:create-promo-banners');
        Route::post('/', [PromoBannerController::class, 'store'])->name('store')->middleware('permission:create-promo-banners');
        Route::get('/{encryptedId}/edit', [PromoBannerController::class, 'edit'])->name('edit')->middleware('permission:edit-promo-banners');
        Route::put('/{encryptedId}', [PromoBannerController::class, 'update'])->name('update')->middleware('permission:edit-promo-banners');
        Route::delete('/{encryptedId}', [PromoBannerController::class, 'destroy'])->name('destroy')->middleware('permission:delete-promo-banners');
    });

    // Home Introduction Management
    Route::prefix('dashboard/home-introductions')->name('dashboard.home-introductions.')->group(function () {
        Route::get('/', [HomeIntroductionController::class, 'index'])->name('index')->middleware('permission:view-home-introduction');
        Route::get('/create', [HomeIntroductionController::class, 'create'])->name('create')->middleware('permission:create-home-introduction');
        Route::post('/', [HomeIntroductionController::class, 'store'])->name('store')->middleware('permission:create-home-introduction');
        Route::get('/{encryptedId}/edit', [HomeIntroductionController::class, 'edit'])->name('edit')->middleware('permission:edit-home-introduction');
        Route::put('/{encryptedId}', [HomeIntroductionController::class, 'update'])->name('update')->middleware('permission:edit-home-introduction');
        Route::delete('/{encryptedId}', [HomeIntroductionController::class, 'destroy'])->name('destroy')->middleware('permission:delete-home-introduction');
    });

    // Office Locations Management
    Route::prefix('dashboard/office-locations')->name('dashboard.office-locations.')->group(function () {
        Route::get('/', [OfficeLocationController::class, 'index'])->name('index')->middleware('permission:view-office-locations');
        Route::get('/create', [OfficeLocationController::class, 'create'])->name('create')->middleware('permission:create-office-locations');
        Route::post('/', [OfficeLocationController::class, 'store'])->name('store')->middleware('permission:create-office-locations');
        Route::get('/{encryptedId}/edit', [OfficeLocationController::class, 'edit'])->name('edit')->middleware('permission:edit-office-locations');
        Route::put('/{encryptedId}', [OfficeLocationController::class, 'update'])->name('update')->middleware('permission:edit-office-locations');
        Route::delete('/{encryptedId}', [OfficeLocationController::class, 'destroy'])->name('destroy')->middleware('permission:delete-office-locations');
    });

    // Gallery Categories Management
    Route::prefix('dashboard/gallery-categories')->name('dashboard.gallery-categories.')->group(function () {
        Route::get('/', [GalleryCategoryController::class, 'index'])->name('index')->middleware('permission:view-gallery-categories');
        Route::get('/create', [GalleryCategoryController::class, 'create'])->name('create')->middleware('permission:create-gallery-categories');
        Route::post('/', [GalleryCategoryController::class, 'store'])->name('store')->middleware('permission:create-gallery-categories');
        Route::get('/{encryptedId}/edit', [GalleryCategoryController::class, 'edit'])->name('edit')->middleware('permission:edit-gallery-categories');
        Route::put('/{encryptedId}', [GalleryCategoryController::class, 'update'])->name('update')->middleware('permission:edit-gallery-categories');
        Route::post('/{encryptedId}/toggle-status', [GalleryCategoryController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-gallery-categories');
        Route::delete('/{encryptedId}', [GalleryCategoryController::class, 'destroy'])->name('destroy')->middleware('permission:delete-gallery-categories');
    });

    // Gallery Management
    Route::prefix('dashboard/galleries')->name('dashboard.galleries.')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('index')->middleware('permission:view-galleries');
        Route::get('/create', [GalleryController::class, 'create'])->name('create')->middleware('permission:create-galleries');
        Route::post('/', [GalleryController::class, 'store'])->name('store')->middleware('permission:create-galleries');
        Route::get('/{encryptedId}/edit', [GalleryController::class, 'edit'])->name('edit')->middleware('permission:edit-galleries');
        Route::put('/{encryptedId}', [GalleryController::class, 'update'])->name('update')->middleware('permission:edit-galleries');
        Route::post('/{encryptedId}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('toggle-status')->middleware('permission:edit-galleries');
        Route::delete('/{encryptedId}', [GalleryController::class, 'destroy'])->name('destroy')->middleware('permission:delete-galleries');
    });

    // Certificate Categories Management
    Route::prefix('dashboard/certificate-categories')->name('dashboard.certificate-categories.')->group(function () {
        Route::get('/', [CertificateCategoryController::class, 'index'])->name('index')->middleware('permission:view-certificate-categories');
        Route::get('/create', [CertificateCategoryController::class, 'create'])->name('create')->middleware('permission:create-certificate-categories');
        Route::post('/', [CertificateCategoryController::class, 'store'])->name('store')->middleware('permission:create-certificate-categories');
        Route::get('/{encryptedId}/edit', [CertificateCategoryController::class, 'edit'])->name('edit')->middleware('permission:edit-certificate-categories');
        Route::put('/{encryptedId}', [CertificateCategoryController::class, 'update'])->name('update')->middleware('permission:edit-certificate-categories');
        Route::delete('/{encryptedId}', [CertificateCategoryController::class, 'destroy'])->name('destroy')->middleware('permission:delete-certificate-categories');
    });

    // Certificate Management
    Route::prefix('dashboard/certificates')->name('dashboard.certificates.')->group(function () {
        Route::get('/', [CertificateController::class, 'index'])->name('index')->middleware('permission:view-certificates');
        Route::get('/create', [CertificateController::class, 'create'])->name('create')->middleware('permission:create-certificates');
        Route::post('/', [CertificateController::class, 'store'])->name('store')->middleware('permission:create-certificates');
        Route::get('/{encryptedId}/edit', [CertificateController::class, 'edit'])->name('edit')->middleware('permission:edit-certificates');
        Route::put('/{encryptedId}', [CertificateController::class, 'update'])->name('update')->middleware('permission:edit-certificates');
        Route::delete('/{encryptedId}', [CertificateController::class, 'destroy'])->name('destroy')->middleware('permission:delete-certificates');
    });

    // Contact Submissions Management
    Route::prefix('dashboard/contact-submissions')->name('dashboard.contact-submissions.')->group(function () {
        Route::get('/', [ContactSubmissionController::class, 'index'])->name('index')->middleware('permission:view-contact-submissions');
        Route::get('/{contactSubmission}', [ContactSubmissionController::class, 'show'])->name('show')->middleware('permission:view-contact-submissions');
        Route::patch('/{contactSubmission}/status', [ContactSubmissionController::class, 'updateStatus'])->name('update-status')->middleware('permission:respond-contact-submissions');
        Route::delete('/{contactSubmission}', [ContactSubmissionController::class, 'destroy'])->name('destroy')->middleware('permission:delete-contact-submissions');
        Route::post('/bulk-delete', [ContactSubmissionController::class, 'bulkDelete'])->name('bulk-delete')->middleware('permission:delete-contact-submissions');
    });

    // ============= RBAC Management =============
    // Permissions Management (View Only)
    Route::prefix('dashboard/rbac/permissions')->name('dashboard.rbac.permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index')->middleware('permission:view-permissions');
    });

    // Roles Management
    Route::prefix('dashboard/rbac/roles')->name('dashboard.rbac.roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index')->middleware('permission:view-roles');
        Route::get('/create', [RoleController::class, 'create'])->name('create')->middleware('permission:create-roles');
        Route::post('/', [RoleController::class, 'store'])->name('store')->middleware('permission:create-roles');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit')->middleware('permission:edit-roles');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update')->middleware('permission:edit-roles');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->middleware('permission:delete-roles');
    });

    // Users Role Assignment
    Route::prefix('dashboard/rbac/users')->name('dashboard.rbac.users.')->group(function () {
        Route::get('/', [UserRoleController::class, 'index'])->name('index')->middleware('permission:view-user-roles');
        Route::get('/{user}/edit', [UserRoleController::class, 'edit'])->name('edit')->middleware('permission:edit-user-roles');
        Route::put('/{user}', [UserRoleController::class, 'update'])->name('update')->middleware('permission:edit-user-roles');
        Route::post('/{user}/assign-role', [UserRoleController::class, 'assignRole'])->name('assign-role')->middleware('permission:edit-user-roles');
        Route::post('/{user}/remove-role', [UserRoleController::class, 'removeRole'])->name('remove-role')->middleware('permission:edit-user-roles');
    });

    // Users Management (CRUD)
    Route::prefix('dashboard/rbac/user-management')->name('dashboard.rbac.user-management.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index')->middleware('permission:view-users');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create')->middleware('permission:create-users');
        Route::post('/', [UserManagementController::class, 'store'])->name('store')->middleware('permission:create-users');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit')->middleware('permission:edit-users');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update')->middleware('permission:edit-users');
        Route::put('/{user}/password', [UserManagementController::class, 'updatePassword'])->name('password')->middleware('permission:edit-users');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy')->middleware('permission:delete-users');
    });
});
