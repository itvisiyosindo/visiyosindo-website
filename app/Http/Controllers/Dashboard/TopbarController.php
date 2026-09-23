<?php

namespace App\Http\Controllers\Dashboard;

use App\Constants\Permission as PermissionConstants;
use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\ProductContent;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class TopbarController extends Controller
{
    /**
     * Perform dashboard quick search (menus + key records).
     */
    public function search(Request $request): JsonResponse
    {
        $user = $request->user();
        $query = trim((string) $request->query('query', ''));

        $menuResults = collect($this->menuItems())
            ->filter(fn (array $item) => $this->canAccess($user, $item['permission'] ?? null))
            ->filter(fn (array $item) => Route::has($item['route']))
            ->map(function (array $item): array {
                return [
                    'type' => 'menu',
                    'title' => $item['title'],
                    'subtitle' => $item['subtitle'],
                    'url' => route($item['route']),
                ];
            });

        if ($query !== '') {
            $menuResults = $menuResults->filter(function (array $item) use ($query): bool {
                return str_contains(strtolower($item['title']), strtolower($query))
                    || str_contains(strtolower($item['subtitle']), strtolower($query));
            });
        }

        $results = $menuResults->take($query === '' ? 8 : 6)->values();

        if ($query !== '' && mb_strlen($query) >= 2) {
            $dynamicResults = collect();

            if ($user->isAdmin() || $user->hasAnyPermission([
                PermissionConstants::CONTACT_SUBMISSION_VIEW,
                PermissionConstants::CONTACT_SUBMISSION_RESPOND,
            ])) {
                $contacts = ContactSubmission::query()
                    ->where(function ($queryBuilder) use ($query): void {
                        $queryBuilder->where('name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%")
                            ->orWhere('company', 'like', "%{$query}%");
                    })
                    ->latest()
                    ->limit(3)
                    ->get();

                $dynamicResults = $dynamicResults->merge($contacts->map(function (ContactSubmission $submission): array {
                    return [
                        'type' => 'contact',
                        'title' => $submission->name,
                        'subtitle' => 'Pesan Masuk - ' . $submission->subject_label,
                        'url' => route('dashboard.contact-submissions.show', $submission),
                    ];
                }));
            }

            if ($user->isAdmin() || $user->hasPermission(PermissionConstants::PRODUCT_VIEW)) {
                $products = ProductContent::withoutGlobalScopes()
                    ->where(function ($queryBuilder) use ($query): void {
                        $queryBuilder->where('name', 'like', "%{$query}%")
                            ->orWhere('brand', 'like', "%{$query}%")
                            ->orWhere('sku', 'like', "%{$query}%");
                    })
                    ->latest()
                    ->limit(3)
                    ->get();

                $dynamicResults = $dynamicResults->merge($products->map(function (ProductContent $product): array {
                    return [
                        'type' => 'product',
                        'title' => $product->name,
                        'subtitle' => 'Produk - ' . ($product->brand ?? 'Tanpa Brand'),
                        'url' => route('dashboard.products.show', $product->encrypted_id),
                    ];
                }));
            }

            if ($user->isAdmin() || $user->hasPermission(PermissionConstants::USER_VIEW)) {
                $users = User::query()
                    ->where(function ($queryBuilder) use ($query): void {
                        $queryBuilder->where('name', 'like', "%{$query}%")
                            ->orWhere('email', 'like', "%{$query}%");
                    })
                    ->latest()
                    ->limit(2)
                    ->get();

                $dynamicResults = $dynamicResults->merge($users->map(function (User $targetUser) use ($user): array {
                    $targetUrl = ($user->isAdmin() || $user->hasPermission(PermissionConstants::USER_EDIT))
                        ? route('dashboard.rbac.user-management.edit', $targetUser)
                        : route('dashboard.rbac.user-management.index', ['search' => $targetUser->name]);

                    return [
                        'type' => 'user',
                        'title' => $targetUser->name,
                        'subtitle' => 'User - ' . $targetUser->email,
                        'url' => $targetUrl,
                    ];
                }));
            }

            $results = $results->merge($dynamicResults)->take(10)->values();
        }

        return response()->json([
            'results' => $results,
        ]);
    }

    /**
     * Get latest notifications for topbar dropdown.
     */
    public function notifications(Request $request): JsonResponse
    {
        $user = $request->user();
        $notifications = $user->notifications()->latest()->limit(15)->get();

        $items = $notifications->map(function ($notification): array {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? 'Notifikasi',
                'message' => $notification->data['message'] ?? '',
                'url' => $notification->data['url'] ?? route('dashboard'),
                'icon' => $notification->data['icon'] ?? 'info',
                'is_unread' => $notification->read_at === null,
                'time' => $notification->created_at?->diffForHumans(),
            ];
        })->values();

        if ($items->isEmpty() && $user->notificationPreference('system_updates', true)) {
            $items->push([
                'id' => 'system-welcome',
                'title' => 'Sistem Notifikasi Aktif',
                'message' => 'Notifikasi pesan masuk dan lamaran kerja akan tampil di sini.',
                'url' => route('dashboard'),
                'icon' => 'info',
                'is_unread' => false,
                'time' => now()->diffForHumans(),
            ]);
        }

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
            'items' => $items,
        ]);
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAllNotificationsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca.',
        ]);
    }

    /**
     * Mark a single notification as read.
     */
    public function markNotificationRead(Request $request, string $notification): JsonResponse
    {
        $target = $request->user()->notifications()->where('id', $notification)->first();

        if ($target && $target->read_at === null) {
            $target->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Determine if current user can access an item by permission requirement.
     */
    private function canAccess(User $user, ?string $permission): bool
    {
        if ($permission === null) {
            return true;
        }

        return $user->isAdmin() || $user->hasPermission($permission);
    }

    /**
     * Dashboard menu index used by quick search.
     *
     * @return array<int, array<string, string|null>>
     */
    private function menuItems(): array
    {
        return [
            ['title' => 'Dashboard', 'subtitle' => 'Ringkasan performa website', 'route' => 'dashboard', 'permission' => PermissionConstants::DASHBOARD_VIEW],
            ['title' => 'Analytics', 'subtitle' => 'Statistik traffic & pengunjung', 'route' => 'dashboard.analytics.index', 'permission' => PermissionConstants::ANALYTICS_VIEW],
            ['title' => 'Contact Form', 'subtitle' => 'Pesan masuk pelanggan', 'route' => 'dashboard.contact-submissions.index', 'permission' => PermissionConstants::CONTACT_SUBMISSION_VIEW],
            ['title' => 'Produk', 'subtitle' => 'Kelola katalog produk', 'route' => 'dashboard.products.index', 'permission' => PermissionConstants::PRODUCT_VIEW],
            ['title' => 'Kategori Produk', 'subtitle' => 'Kelola kategori produk', 'route' => 'dashboard.products.categories.index', 'permission' => PermissionConstants::PRODUCT_CATEGORY_VIEW],
            ['title' => 'Lowongan Kerja', 'subtitle' => 'Kelola karir & rekrutmen', 'route' => 'dashboard.careers.index', 'permission' => PermissionConstants::CAREER_VIEW],
            ['title' => 'Hero Carousel', 'subtitle' => 'Kelola slider homepage', 'route' => 'dashboard.hero-slides.index', 'permission' => PermissionConstants::HERO_SLIDE_VIEW],
            ['title' => 'Promo Banners', 'subtitle' => 'Kelola banner promosi', 'route' => 'dashboard.promo-banners.index', 'permission' => PermissionConstants::PROMO_BANNER_VIEW],
            ['title' => 'Introduction', 'subtitle' => 'Kelola intro homepage', 'route' => 'dashboard.home-introductions.index', 'permission' => PermissionConstants::HOME_INTRO_VIEW],
            ['title' => 'News & Updates', 'subtitle' => 'Kelola berita website', 'route' => 'dashboard.news.index', 'permission' => PermissionConstants::NEWS_VIEW],
            ['title' => 'Gallery', 'subtitle' => 'Kelola galeri website', 'route' => 'dashboard.galleries.index', 'permission' => PermissionConstants::GALLERY_VIEW],
            ['title' => 'Kategori Gallery', 'subtitle' => 'Kelola kategori galeri', 'route' => 'dashboard.gallery-categories.index', 'permission' => PermissionConstants::GALLERY_CATEGORY_VIEW],
            ['title' => 'Sertifikasi', 'subtitle' => 'Kelola sertifikat perusahaan', 'route' => 'dashboard.certificates.index', 'permission' => PermissionConstants::CERTIFICATE_VIEW],
            ['title' => 'Kategori Sertifikasi', 'subtitle' => 'Kelola kategori sertifikat', 'route' => 'dashboard.certificate-categories.index', 'permission' => PermissionConstants::CERTIFICATE_CATEGORY_VIEW],
            ['title' => 'Partners', 'subtitle' => 'Kelola partner perusahaan', 'route' => 'dashboard.partners.index', 'permission' => PermissionConstants::PARTNER_VIEW],
            ['title' => 'Clients', 'subtitle' => 'Kelola client perusahaan', 'route' => 'dashboard.clients.index', 'permission' => PermissionConstants::PARTNER_VIEW],
            ['title' => 'Halaman SGM', 'subtitle' => 'Konten halaman subsidiary SGM', 'route' => 'dashboard.sgm-page.edit', 'permission' => PermissionConstants::SGM_PAGE_VIEW],
            ['title' => 'Halaman Visilab', 'subtitle' => 'Konten layanan visilab', 'route' => 'dashboard.visilab-pages.index', 'permission' => PermissionConstants::VISILAB_PAGE_VIEW],
            ['title' => 'Map Markers', 'subtitle' => 'Kelola titik peta kantor', 'route' => 'dashboard.map-markers.index', 'permission' => PermissionConstants::MAP_MARKER_VIEW],
            ['title' => 'My Profile', 'subtitle' => 'Kelola data akun pribadi', 'route' => 'dashboard.account.profile', 'permission' => null],
            ['title' => 'Settings', 'subtitle' => 'Atur preferensi dashboard', 'route' => 'dashboard.account.settings', 'permission' => null],
        ];
    }
}
