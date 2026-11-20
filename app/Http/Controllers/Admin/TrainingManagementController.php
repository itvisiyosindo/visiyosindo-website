<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateCode;
use App\Models\StudentCertificate;
use App\Models\TrainingClass;
use App\Models\TrainingEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrainingManagementController extends Controller
{
    /**
     * Authorize that the current user has access to training management.
     */
    private function authorizeManager(): void
    {
        $user = Auth::user();
        if ($user && $user->isStudent() && !$user->isAdmin() && !$user->isAcademyAdmin()) {
            abort(403, 'Akses terbatas untuk Administrator Visilab Academy.');
        }
    }

    /**
     * 1. Display listing of training enrollments (Peserta & Verifikasi Pembayaran).
     */
    public function index(Request $request): View
    {
        $this->authorizeManager();

        $query = TrainingEnrollment::with(['user', 'trainingClass', 'certificate'])
            ->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($classId = $request->get('training_class_id')) {
            $query->where('training_class_id', $classId);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%");
                })->orWhereHas('trainingClass', function ($tq) use ($search) {
                    $tq->where('title', 'like', "%{$search}%");
                });
            });
        }

        $enrollments = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => TrainingEnrollment::count(),
            'pending' => TrainingEnrollment::where('status', TrainingEnrollment::STATUS_PENDING)->count(),
            'active' => TrainingEnrollment::where('status', TrainingEnrollment::STATUS_ACTIVE)->count(),
            'completed' => TrainingEnrollment::where('status', TrainingEnrollment::STATUS_COMPLETED)->count(),
        ];

        $classesList = TrainingClass::select('id', 'title', 'batch_name')->get();

        return view('dashboard.management.trainings.index', compact('enrollments', 'stats', 'classesList'));
    }

    /**
     * Approve student enrollment (payment confirmed via WA/transfer).
     */
    public function approve(int $id): RedirectResponse
    {
        $this->authorizeManager();

        $enrollment = TrainingEnrollment::findOrFail($id);
        $enrollment->update([
            'status' => TrainingEnrollment::STATUS_ACTIVE,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Status pendaftaran peserta berhasil disetujui (Aktif).',
        ]);
    }

    /**
     * Reject or cancel enrollment.
     */
    public function reject(int $id): RedirectResponse
    {
        $this->authorizeManager();

        $enrollment = TrainingEnrollment::findOrFail($id);
        $enrollment->update([
            'status' => TrainingEnrollment::STATUS_CANCELLED,
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'warning',
            'message' => 'Pendaftaran peserta berhasil dibatalkan.',
        ]);
    }

    /**
     * Mark training completed and issue certificate.
     */
    public function complete(int $id): RedirectResponse
    {
        $this->authorizeManager();

        $enrollment = TrainingEnrollment::findOrFail($id);
        $enrollment->update([
            'status' => TrainingEnrollment::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        // Issue certificate if not already issued
        if (!$enrollment->certificate) {
            $year = date('Y');
            $month = date('m');
            $certNumber = sprintf('CERT/VISILAB/%s/%s/%04d', $year, $month, $enrollment->id);
            $verificationCode = 'VSI-' . strtoupper(Str::random(8));

            StudentCertificate::create([
                'training_enrollment_id' => $enrollment->id,
                'user_id' => $enrollment->user_id,
                'training_class_id' => $enrollment->training_class_id,
                'certificate_number' => $certNumber,
                'verification_code' => $verificationCode,
                'issued_date' => now()->toDateString(),
            ]);
        }

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Peserta berhasil diluluskan dan e-Sertifikat resmi telah diterbitkan!',
        ]);
    }

    /**
     * 2. Display listing of all training classes (Katalog & Kelola Kelas).
     */
    public function classesIndex(Request $request): View
    {
        $this->authorizeManager();

        $query = TrainingClass::withCount('enrollments')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('batch_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_active') && $request->get('is_active') !== '') {
            $query->where('is_active', (bool) $request->get('is_active'));
        }

        $classes = $query->paginate(12)->withQueryString();

        $stats = [
            'total' => TrainingClass::count(),
            'active' => TrainingClass::where('is_active', true)->count(),
            'inactive' => TrainingClass::where('is_active', false)->count(),
            'total_students' => TrainingEnrollment::count(),
        ];

        return view('dashboard.management.trainings.classes', compact('classes', 'stats'));
    }

    /**
     * Store a newly created training class.
     */
    public function classesStore(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        // Sanitize price (allow e.g. "150.000", "Rp 150.000", or "150000")
        if ($request->has('price')) {
            $rawPrice = preg_replace('/[^0-9]/', '', (string) $request->input('price', 0));
            $request->merge(['price' => $rawPrice === '' ? 0 : (int) $rawPrice]);
        }

        // Sanitize URLs (auto prepend https:// if missing)
        if ($request->filled('whatsapp_group_link')) {
            $wa = trim($request->input('whatsapp_group_link'));
            if (!preg_match('~^(?:f|ht)tps?://~i', $wa)) {
                $request->merge(['whatsapp_group_link' => 'https://' . $wa]);
            }
        }
        if ($request->filled('materials_link')) {
            $mat = trim($request->input('materials_link'));
            if (!preg_match('~^(?:f|ht)tps?://~i', $mat)) {
                $request->merge(['materials_link' => 'https://' . $mat]);
            }
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'batch_name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'schedule' => ['nullable', 'string', 'max:150'],
            'whatsapp_group_link' => ['nullable', 'string', 'max:255'],
            'materials_link' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ], [
            'title.required' => 'Judul kelas wajib diisi.',
            'category.required' => 'Kategori kelas wajib diisi.',
            'batch_name.required' => 'Nama batch wajib diisi.',
            'price.required' => 'Harga pelatihan wajib diisi (isi 0 jika gratis).',
            'image.image' => 'File flyer harus berupa gambar (JPG, PNG, atau WEBP).',
            'image.max' => 'Ukuran file flyer maksimal 5 MB.',
        ]);

        $baseSlug = Str::slug($validated['title'] . '-' . $validated['batch_name']);
        if (empty($baseSlug)) {
            $baseSlug = 'kelas-' . time();
        }

        $slug = $baseSlug;
        $counter = 1;

        while (TrainingClass::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('trainings/flyers', 'public');
        }

        TrainingClass::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'batch_name' => $validated['batch_name'],
            'price' => (int) $validated['price'],
            'duration' => $validated['duration'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'whatsapp_group_link' => $validated['whatsapp_group_link'] ?? null,
            'materials_link' => $validated['materials_link'] ?? null,
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('dashboard.trainings.classes')->with('toast', [
            'type' => 'success',
            'message' => 'Kelas pelatihan baru berhasil dibuat!',
        ]);
    }

    /**
     * Update an existing training class.
     */
    public function classesUpdate(Request $request, int $id): RedirectResponse
    {
        $this->authorizeManager();

        $trainingClass = TrainingClass::findOrFail($id);

        if ($request->has('price')) {
            $rawPrice = preg_replace('/[^0-9]/', '', (string) $request->input('price', 0));
            $request->merge(['price' => $rawPrice === '' ? 0 : (int) $rawPrice]);
        }

        if ($request->filled('whatsapp_group_link')) {
            $wa = trim($request->input('whatsapp_group_link'));
            if (!preg_match('~^(?:f|ht)tps?://~i', $wa)) {
                $request->merge(['whatsapp_group_link' => 'https://' . $wa]);
            }
        }
        if ($request->filled('materials_link')) {
            $mat = trim($request->input('materials_link'));
            if (!preg_match('~^(?:f|ht)tps?://~i', $mat)) {
                $request->merge(['materials_link' => 'https://' . $mat]);
            }
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'batch_name' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['nullable', 'string', 'max:100'],
            'schedule' => ['nullable', 'string', 'max:150'],
            'whatsapp_group_link' => ['nullable', 'string', 'max:255'],
            'materials_link' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ], [
            'image.image' => 'File flyer harus berupa gambar (JPG, PNG, atau WEBP).',
            'image.max' => 'Ukuran file flyer maksimal 5 MB.',
        ]);

        $imagePath = $trainingClass->image;
        if ($request->hasFile('image')) {
            if ($trainingClass->image && Storage::disk('public')->exists($trainingClass->image)) {
                Storage::disk('public')->delete($trainingClass->image);
            }
            $imagePath = $request->file('image')->store('trainings/flyers', 'public');
        } elseif ($request->boolean('remove_image')) {
            if ($trainingClass->image && Storage::disk('public')->exists($trainingClass->image)) {
                Storage::disk('public')->delete($trainingClass->image);
            }
            $imagePath = null;
        }

        $trainingClass->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'batch_name' => $validated['batch_name'],
            'price' => (int) $validated['price'],
            'duration' => $validated['duration'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'whatsapp_group_link' => $validated['whatsapp_group_link'] ?? null,
            'materials_link' => $validated['materials_link'] ?? null,
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('dashboard.trainings.classes')->with('toast', [
            'type' => 'success',
            'message' => 'Perubahan kelas berhasil disimpan!',
        ]);
    }

    /**
     * Toggle active/inactive status of a class.
     */
    public function classesToggleActive(int $id): RedirectResponse
    {
        $this->authorizeManager();

        $class = TrainingClass::findOrFail($id);
        $class->is_active = !$class->is_active;
        $class->save();

        $statusText = $class->is_active ? 'dibuka' : 'ditutup';

        return redirect()->back()->with('toast', [
            'type' => 'info',
            'message' => "Pendaftaran kelas {$class->title} berhasil {$statusText}.",
        ]);
    }

    /**
     * Delete a training class.
     */
    public function classesDestroy(int $id): RedirectResponse
    {
        $this->authorizeManager();

        $class = TrainingClass::findOrFail($id);
        $class->delete();

        return redirect()->route('dashboard.trainings.classes')->with('toast', [
            'type' => 'success',
            'message' => 'Kelas pelatihan berhasil dihapus.',
        ]);
    }

    /**
     * 3. Display list of all issued certificates.
     */
    public function certificatesIndex(Request $request): View
    {
        $this->authorizeManager();

        $query = StudentCertificate::with(['user', 'trainingClass', 'enrollment'])->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('certificate_number', 'like', "%{$search}%")
                  ->orWhere('verification_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $certificates = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => StudentCertificate::count(),
            'this_year' => StudentCertificate::whereYear('created_at', date('Y'))->count(),
            'this_month' => StudentCertificate::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count(),
        ];

        return view('dashboard.management.trainings.certificates', compact('certificates', 'stats'));
    }

    /**
     * 4. Display list of all student affiliate codes & performance.
     */
    public function affiliatesIndex(Request $request): View
    {
        $this->authorizeManager();

        $query = AffiliateCode::with('user')->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $affiliates = $query->paginate(15)->withQueryString();

        $stats = [
            'total_codes' => AffiliateCode::count(),
            'total_usage' => AffiliateCode::sum('usage_count'),
            'total_commission' => AffiliateCode::sum('total_commission'),
        ];

        return view('dashboard.management.trainings.affiliates', compact('affiliates', 'stats'));
    }
}
