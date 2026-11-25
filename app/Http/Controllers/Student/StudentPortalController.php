<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademySetting;
use App\Models\AffiliateCode;
use App\Models\AffiliateWithdrawal;
use App\Models\NewsPost;
use App\Models\StudentCertificate;
use App\Models\TrainingClass;
use App\Models\TrainingEnrollment;
use App\Models\TrainingMaterial;
use App\Models\User;
use App\Support\AcademySchemaEnsurer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentPortalController extends Controller
{
    /**
     * Display student portal dashboard with left sidebar navigation:
     * (Overview, Kelas Saya, Daftar Kelas, Riwayat Belajar, Afiliasi, Invoice, Profil & Akun).
     */
    public function dashboard(): View
    {
        AcademySchemaEnsurer::ensure();

        $user = Auth::user();
        $academySettings = AcademySetting::allSettings();
        $adminWhatsApp = $academySettings['admin_whatsapp'];
        $discountPercent = (int) ($academySettings['affiliate_discount_percent'] ?? 5);
        $commissionPercent = (int) ($academySettings['affiliate_commission_percent'] ?? 2);
        $minWithdrawal = (int) ($academySettings['affiliate_min_withdrawal'] ?? 50000);

        // Enrollments with class, materials, certificate & affiliate
        $withRelations = ['trainingClass', 'certificate'];
        if (Schema::hasTable('training_materials')) {
            $withRelations[] = 'trainingClass.materials';
        }
        if (Schema::hasColumn('training_enrollments', 'affiliate_code_id')) {
            $withRelations[] = 'affiliateCode';
        }

        $enrollments = $user->enrollments()
            ->with($withRelations)
            ->latest()
            ->get();

        // Certificates
        $certificates = $user->studentCertificates()
            ->with('trainingClass')
            ->latest()
            ->get();

        // Self-heal: ensure enrollment has relation to certificate if created without training_enrollment_id
        foreach ($enrollments as $enr) {
            if (!$enr->certificate) {
                $fallbackCert = $certificates->firstWhere('training_class_id', $enr->training_class_id);
                if ($fallbackCert) {
                    if (!$fallbackCert->training_enrollment_id) {
                        $fallbackCert->update(['training_enrollment_id' => $enr->id]);
                    }
                    $enr->setRelation('certificate', $fallbackCert);
                }
            }
        }

        // Available classes currently open for registration
        $availableClasses = TrainingClass::where('is_active', true)->latest()->get();
        $enrolledClassIds = $enrollments
            ->where('status', '!=', TrainingEnrollment::STATUS_CANCELLED)
            ->pluck('training_class_id')
            ->toArray();

        // Ensure affiliate_codes table exists
        $this->ensureAffiliateTableExists();

        // Fetch or initialize student's affiliate codes
        $affiliateCodes = collect();
        try {
            $affiliateCodes = AffiliateCode::where('user_id', $user->id)->latest()->get();

            if ($affiliateCodes->isEmpty()) {
                $cleanName = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $user->name) ?: 'PELAJAR', 0, 5));
                $generatedCode = 'VISI-' . $cleanName . rand(100, 999);

                while (AffiliateCode::where('code', $generatedCode)->exists()) {
                    $generatedCode = 'VISI-' . $cleanName . rand(100, 999);
                }

                $defaultCode = AffiliateCode::create([
                    'user_id' => $user->id,
                    'code' => $generatedCode,
                    'discount_percent' => $discountPercent,
                    'commission_percent' => $commissionPercent,
                    'usage_count' => 0,
                    'total_commission' => 0,
                    'is_active' => true,
                ]);

                $affiliateCodes = collect([$defaultCode]);
            }
        } catch (\Throwable $e) {
            $affiliateCodes = collect();
        }

        $codeIds = $affiliateCodes->pluck('id')->filter()->toArray();
        $totalCommission = (int) $affiliateCodes->sum('total_commission');

        $thisMonthCommission = 0;
        $recentReferrals = collect();
        $withdrawals = collect();
        $withdrawnAmount = 0;
        $pendingWithdrawalAmount = 0;

        try {
            if (!empty($codeIds) && Schema::hasColumn('training_enrollments', 'affiliate_code_id')) {
                $thisMonthCommission = (int) TrainingEnrollment::whereIn('affiliate_code_id', $codeIds)
                    ->whereNotNull('commission_awarded_at')
                    ->whereMonth('commission_awarded_at', now()->month)
                    ->whereYear('commission_awarded_at', now()->year)
                    ->sum('affiliate_commission');

                $recentReferrals = TrainingEnrollment::with(['user', 'trainingClass', 'affiliateCode'])
                    ->whereIn('affiliate_code_id', $codeIds)
                    ->whereNotNull('commission_awarded_at')
                    ->latest('commission_awarded_at')
                    ->take(10)
                    ->get();
            }

            if (Schema::hasTable('affiliate_withdrawals')) {
                $withdrawals = AffiliateWithdrawal::where('user_id', $user->id)
                    ->latest()
                    ->take(20)
                    ->get();

                $withdrawnAmount = (int) AffiliateWithdrawal::where('user_id', $user->id)
                    ->where('status', AffiliateWithdrawal::STATUS_PAID)
                    ->sum('amount');

                $pendingWithdrawalAmount = (int) AffiliateWithdrawal::where('user_id', $user->id)
                    ->where('status', AffiliateWithdrawal::STATUS_PENDING)
                    ->sum('amount');
            }
        } catch (\Throwable $e) {
            // Keep resilient defaults if migrations haven't run yet
        }

        $availableBalance = max(0, $totalCommission - $withdrawnAmount - $pendingWithdrawalAmount);

        $affiliateStats = [
            'balance' => $availableBalance,
            'this_month' => $thisMonthCommission,
            'withdrawn' => $withdrawnAmount,
            'pending_withdrawal' => $pendingWithdrawalAmount,
            'total' => $totalCommission,
            'discount_percent' => $discountPercent,
            'commission_percent' => $commissionPercent,
            'min_withdrawal' => $minWithdrawal,
        ];

        $learningStats = [
            'total_classes' => $enrollments->where('status', '!=', TrainingEnrollment::STATUS_CANCELLED)->count(),
            'active_classes' => $enrollments->where('status', TrainingEnrollment::STATUS_ACTIVE)->count(),
            'completed_classes' => $enrollments->where('status', TrainingEnrollment::STATUS_COMPLETED)->count(),
            'total_certificates' => $certificates->count(),
        ];

        // Format Invoices list from enrollments using snapshotted amounts
        $invoices = $enrollments->map(function ($enrollment) {
            $date = $enrollment->created_at ?? now();
            $invNo = $enrollment->effective_invoice_no;
            $baseAmount = $enrollment->effective_base_price;
            $discountAmount = (int) ($enrollment->discount_amount ?? 0);
            $finalAmount = $enrollment->effective_final_price;
            $isPaid = $enrollment->isPaid();
            $isCancelled = $enrollment->isCancelled();

            return (object) [
                'id' => $enrollment->id,
                'training_class_id' => $enrollment->training_class_id,
                'invoice_no' => $invNo,
                'class_title' => $enrollment->trainingClass->title ?? 'Pelatihan Medikal',
                'batch_name' => $enrollment->trainingClass->batch_name ?? 'Batch Reguler',
                'base_amount' => $baseAmount,
                'discount_amount' => $discountAmount,
                'amount' => $finalAmount,
                'formatted_base_amount' => $baseAmount > 0 ? 'Rp ' . number_format($baseAmount, 0, ',', '.') : 'Gratis',
                'formatted_discount' => $discountAmount > 0 ? 'Rp ' . number_format($discountAmount, 0, ',', '.') : null,
                'formatted_amount' => $finalAmount > 0 ? 'Rp ' . number_format($finalAmount, 0, ',', '.') : 'Gratis',
                'affiliate_code' => $enrollment->affiliateCode->code ?? null,
                'date' => $date->translatedFormat('d F Y, H:i'),
                'raw_date' => $date,
                'status' => $enrollment->status,
                'status_label' => $enrollment->status_label,
                'is_paid' => $isPaid,
                'is_cancelled' => $isCancelled,
                'has_payment_proof' => $enrollment->hasPaymentProof(),
                'payment_proof_uploaded_at' => $enrollment->payment_proof_uploaded_at?->translatedFormat('d M Y, H:i'),
                'payment_proof_url' => $enrollment->hasPaymentProof() ? route('student.enrollment.payment-proof.view', $enrollment->id) : null,
                'rejection_reason' => $enrollment->rejection_reason,
                'enrollment' => $enrollment,
            ];
        });

        // Unique digital member pass ID (deterministic per member, no extra schema required)
        $memberCardId = 'VA-' . ($user->created_at ? $user->created_at->format('Ym') : now()->format('Ym')) . '-' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT);

        // Latest published news & updates for the member information hub
        try {
            $latestNews = NewsPost::published()
                ->latest('published_at')
                ->take(3)
                ->get();
        } catch (\Throwable $e) {
            $latestNews = collect();
        }

        return view('student.dashboard', compact(
            'user',
            'memberCardId',
            'latestNews',
            'academySettings',
            'enrollments',
            'certificates',
            'availableClasses',
            'enrolledClassIds',
            'affiliateCodes',
            'affiliateStats',
            'recentReferrals',
            'withdrawals',
            'learningStats',
            'invoices',
            'adminWhatsApp'
        ));
    }

    /**
     * Display catalogue of available training classes (public page).
     */
    public function classes(Request $request): View
    {
        AcademySchemaEnsurer::ensure();
        $this->captureReferral($request);

        $classes = TrainingClass::where('is_active', true)->latest()->get();
        $enrolledClassIds = Auth::user()
            ? Auth::user()->enrollments()
                ->where('status', '!=', TrainingEnrollment::STATUS_CANCELLED)
                ->pluck('training_class_id')
                ->toArray()
            : [];
        $academySettings = AcademySetting::allSettings();

        return view('student.classes', compact('classes', 'enrolledClassIds', 'academySettings'));
    }

    /**
     * Display full detail page for a training class (public page).
     */
    public function classDetail(Request $request, string $slug): View
    {
        AcademySchemaEnsurer::ensure();
        $this->captureReferral($request);

        $query = TrainingClass::where('slug', $slug)
            ->where('is_active', true);

        if (Schema::hasTable('training_materials')) {
            $query->withCount('materials');
        }

        $trainingClass = $query->firstOrFail();

        $existingEnrollment = Auth::check()
            ? Auth::user()->enrollments()
                ->where('training_class_id', $trainingClass->id)
                ->first()
            : null;

        $academySettings = AcademySetting::allSettings();

        return view('student.class-detail', compact('trainingClass', 'existingEnrollment', 'academySettings'));
    }

    /**
     * Display checkout page for enrolling in a class.
     */
    public function checkout(Request $request, int $id): View|RedirectResponse
    {
        AcademySchemaEnsurer::ensure();
        $this->captureReferral($request);

        $trainingClass = TrainingClass::where('is_active', true)->findOrFail($id);
        $user = Auth::user();

        $existing = TrainingEnrollment::where('user_id', $user->id)
            ->where('training_class_id', $trainingClass->id)
            ->first();

        if ($existing && !$existing->isCancelled()) {
            return redirect()->route('student.dashboard', ['#classes'])->with('toast', [
                'type' => 'info',
                'message' => 'Anda sudah terdaftar pada program ' . $trainingClass->title . '.',
            ]);
        }

        if (!$trainingClass->is_registration_open) {
            $reason = $trainingClass->is_coming_soon_program
                ? 'Program ini masih Coming Soon. Jadwal pendaftaran akan segera diumumkan.'
                : ($trainingClass->is_full
                    ? 'Maaf, kuota member untuk program ini sudah penuh.'
                    : 'Maaf, batas waktu pendaftaran program ini telah berakhir.');

            return redirect()->route('student.classes.show', $trainingClass->slug)->with('toast', [
                'type' => 'warning',
                'message' => $reason,
            ]);
        }

        $academySettings = AcademySetting::allSettings();
        $discountPercent = (int) ($academySettings['affiliate_discount_percent'] ?? 5);

        $referralCode = (string) session('affiliate_ref', '');
        $referralPreview = null;

        if ($referralCode !== '' && $trainingClass->price > 0) {
            $affiliate = AffiliateCode::where('code', $referralCode)
                ->where('is_active', true)
                ->first();

            if ($affiliate && $affiliate->user_id !== $user->id) {
                $discountAmount = (int) round($trainingClass->price * ($discountPercent / 100));
                $referralPreview = [
                    'code' => $affiliate->code,
                    'discount_percent' => $discountPercent,
                    'discount_amount' => $discountAmount,
                    'final_price' => max(0, $trainingClass->price - $discountAmount),
                ];
            } else {
                $referralCode = '';
            }
        }

        return view('student.checkout', compact(
            'trainingClass',
            'user',
            'academySettings',
            'referralCode',
            'referralPreview',
            'existing'
        ));
    }

    /**
     * Validate an affiliate referral code via AJAX on checkout.
     */
    public function validateAffiliateCode(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'max:32'],
            'class_id' => ['required', 'integer'],
        ]);

        $user = Auth::user();
        $trainingClass = TrainingClass::where('is_active', true)->findOrFail($request->integer('class_id'));
        $codeUpper = strtoupper(trim($request->input('code')));

        $affiliate = AffiliateCode::with('user')
            ->where('code', $codeUpper)
            ->where('is_active', true)
            ->first();

        if (!$affiliate) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode afiliasi tidak ditemukan atau tidak aktif.',
            ], 422);
        }

        $affiliatePhone = $this->normalizePhone($affiliate->user?->phone);
        $userPhone = $this->normalizePhone($user->phone);
        if ($affiliate->user_id === $user->id || ($affiliatePhone !== '' && $userPhone !== '' && $affiliatePhone === $userPhone)) {
            return response()->json([
                'valid' => false,
                'message' => 'Anda tidak dapat menggunakan kode afiliasi milik sendiri atau nomor WhatsApp yang sama.',
            ], 422);
        }

        $discountPercent = (int) AcademySetting::getValue('affiliate_discount_percent', '5');
        $basePrice = (int) $trainingClass->price;
        $discountAmount = $basePrice > 0 ? (int) round($basePrice * ($discountPercent / 100)) : 0;
        $finalPrice = max(0, $basePrice - $discountAmount);

        return response()->json([
            'valid' => true,
            'code' => $affiliate->code,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'final_price' => $finalPrice,
            'formatted_discount' => 'Rp ' . number_format($discountAmount, 0, ',', '.'),
            'formatted_final_price' => $finalPrice > 0 ? 'Rp ' . number_format($finalPrice, 0, ',', '.') : 'Gratis',
            'message' => "Kode {$affiliate->code} diterapkan! Diskon {$discountPercent}% aktif.",
        ]);
    }

    /**
     * Enroll in a training class (with atomic quota lock, price snapshot, and referral validation).
     */
    public function enroll(Request $request, int $id): RedirectResponse
    {
        AcademySchemaEnsurer::ensure();

        $validated = $request->validate([
            'affiliate_code' => ['nullable', 'string', 'max:32'],
        ]);

        $user = Auth::user();
        $academySettings = AcademySetting::allSettings();
        $discountPercent = (int) ($academySettings['affiliate_discount_percent'] ?? 5);
        $commissionPercent = (int) ($academySettings['affiliate_commission_percent'] ?? 2);

        return DB::transaction(function () use ($id, $user, $validated, $discountPercent, $commissionPercent) {
            $trainingClass = TrainingClass::where('id', $id)
                ->where('is_active', true)
                ->lockForUpdate()
                ->firstOrFail();

            $existing = TrainingEnrollment::where('user_id', $user->id)
                ->where('training_class_id', $trainingClass->id)
                ->lockForUpdate()
                ->first();

            if ($existing && !$existing->isCancelled()) {
                return redirect()->route('student.dashboard', ['#classes'])->with('toast', [
                    'type' => 'info',
                    'message' => 'Anda sudah terdaftar pada program ' . $trainingClass->title . '.',
                ]);
            }

            if (!$trainingClass->is_registration_open) {
                $reason = $trainingClass->is_coming_soon_program
                    ? 'Pendaftaran belum dibuka karena program ini masih berstatus Coming Soon.'
                    : ($trainingClass->is_full
                        ? 'Pendaftaran gagal karena kuota program sudah penuh.'
                        : 'Pendaftaran gagal karena batas pendaftaran telah berakhir.');

                return redirect()->route('student.classes.show', $trainingClass->slug)->with('toast', [
                    'type' => 'error',
                    'message' => $reason,
                ]);
            }

            $basePrice = (int) $trainingClass->price;
            $affiliate = null;

            if (!empty($validated['affiliate_code']) && $basePrice > 0) {
                $codeUpper = strtoupper(trim($validated['affiliate_code']));
                $affiliate = AffiliateCode::with('user')
                    ->where('code', $codeUpper)
                    ->where('is_active', true)
                    ->first();

                if (!$affiliate) {
                    return back()->withInput()->with('toast', [
                        'type' => 'error',
                        'message' => "Kode afiliasi \"{$codeUpper}\" tidak valid atau sudah nonaktif.",
                    ]);
                }

                $affiliatePhone = $this->normalizePhone($affiliate->user?->phone);
                $userPhone = $this->normalizePhone($user->phone);
                if ($affiliate->user_id === $user->id || ($affiliatePhone !== '' && $userPhone !== '' && $affiliatePhone === $userPhone)) {
                    return back()->withInput()->with('toast', [
                        'type' => 'error',
                        'message' => 'Anda tidak dapat menggunakan kode afiliasi milik sendiri atau nomor WhatsApp yang sama.',
                    ]);
                }
            }

            $discountAmount = ($affiliate && $basePrice > 0)
                ? (int) round($basePrice * ($discountPercent / 100))
                : 0;
            $finalPrice = max(0, $basePrice - $discountAmount);
            $affiliateCommission = ($affiliate && $finalPrice > 0)
                ? (int) round($finalPrice * ($commissionPercent / 100))
                : 0;

            do {
                $invoiceNo = 'INV-VYM-' . now()->format('Ym') . '-' . strtoupper(Str::random(6));
            } while (TrainingEnrollment::where('invoice_number', $invoiceNo)->exists());

            $isFree = $basePrice === 0 || $finalPrice === 0;

            $payload = [
                'invoice_number' => $invoiceNo,
                'status' => $isFree ? TrainingEnrollment::STATUS_ACTIVE : TrainingEnrollment::STATUS_PENDING,
                'payment_method' => $isFree ? 'free' : 'bank_transfer',
                'base_price' => $basePrice,
                'discount_amount' => $discountAmount,
                'final_price' => $finalPrice,
                'affiliate_code_id' => $affiliate?->id,
                'affiliate_commission' => $affiliateCommission,
                'commission_awarded_at' => null,
                'payment_proof_path' => null,
                'payment_proof_uploaded_at' => null,
                'approved_at' => $isFree ? now() : null,
                'completed_at' => null,
                'rejection_reason' => null,
            ];

            if ($existing && $existing->isCancelled()) {
                $existing->update($payload);
                $enrollment = $existing;
            } else {
                $enrollment = TrainingEnrollment::create(array_merge($payload, [
                    'user_id' => $user->id,
                    'training_class_id' => $trainingClass->id,
                ]));
            }

            session()->forget('affiliate_ref');

            if ($isFree) {
                return redirect()->route('student.classroom', $enrollment->id)->with('toast', [
                    'type' => 'success',
                    'message' => 'Pendaftaran kelas gratis berhasil! Anda langsung dapat mengakses ruang kelas.',
                ]);
            }

            return redirect()->route('student.dashboard', ['#invoices'])->with('toast', [
                'type' => 'success',
                'message' => 'Pendaftaran berhasil! Silakan transfer sesuai invoice dan unggah bukti pembayaran.',
            ]);
        });
    }

    /**
     * Upload payment proof for a pending enrollment.
     */
    public function uploadPaymentProof(Request $request, int $id): RedirectResponse
    {
        AcademySchemaEnsurer::ensure();

        $user = Auth::user();
        $enrollment = TrainingEnrollment::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($enrollment->status !== TrainingEnrollment::STATUS_PENDING) {
            return redirect()->route('student.dashboard', ['#invoices'])->with('toast', [
                'type' => 'warning',
                'message' => $enrollment->isPaid()
                    ? 'Pembayaran untuk kelas ini sudah diverifikasi lunas.'
                    : 'Pendaftaran ini sudah dibatalkan. Silakan lakukan pendaftaran ulang terlebih dahulu.',
            ]);
        }

        $request->validate([
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ], [
            'payment_proof.required' => 'Silakan pilih file bukti transfer terlebih dahulu.',
            'payment_proof.mimes' => 'Format bukti transfer harus berupa JPG, PNG, WEBP, atau PDF.',
            'payment_proof.max' => 'Ukuran file bukti transfer maksimal 5 MB.',
        ]);

        if ($enrollment->payment_proof_path && Storage::disk('local')->exists($enrollment->payment_proof_path)) {
            Storage::disk('local')->delete($enrollment->payment_proof_path);
        }

        $path = $request->file('payment_proof')->store('trainings/payment-proofs', 'local');

        $enrollment->update([
            'payment_proof_path' => $path,
            'payment_proof_uploaded_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('student.dashboard', ['#invoices'])->with('toast', [
            'type' => 'success',
            'message' => 'Bukti pembayaran berhasil diunggah! Admin akan segera memverifikasi pembayaran Anda.',
        ]);
    }

    /**
     * Stream student's own uploaded payment proof.
     */
    public function viewPaymentProof(int $id): BinaryFileResponse
    {
        $enrollment = TrainingEnrollment::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$enrollment->payment_proof_path || !Storage::disk('local')->exists($enrollment->payment_proof_path)) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        return response()->file(
            Storage::disk('local')->path($enrollment->payment_proof_path),
            ['X-Content-Type-Options' => 'nosniff']
        );
    }

    /**
     * Protected Classroom for active/completed students.
     */
    public function classroom(int $id): View
    {
        AcademySchemaEnsurer::ensure();

        $relations = ['trainingClass', 'certificate'];
        if (Schema::hasTable('training_materials')) {
            $relations[] = 'trainingClass.materials';
        }

        $enrollment = TrainingEnrollment::with($relations)
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Self-heal fallback: link certificate if not connected by training_enrollment_id
        if (!$enrollment->certificate) {
            $fallbackCert = StudentCertificate::where('user_id', $enrollment->user_id)
                ->where('training_class_id', $enrollment->training_class_id)
                ->latest('id')
                ->first();
            if ($fallbackCert) {
                if (!$fallbackCert->training_enrollment_id) {
                    $fallbackCert->update(['training_enrollment_id' => $enrollment->id]);
                }
                $enrollment->setRelation('certificate', $fallbackCert);
            }
        }

        if (!$enrollment->isPaid()) {
            abort(403, 'Akses ruang kelas hanya tersedia setelah pembayaran diverifikasi.');
        }

        $academySettings = AcademySetting::allSettings();

        return view('student.classroom', compact('enrollment', 'academySettings'));
    }

    /**
     * Stream or redirect to a protected class material.
     */
    public function downloadMaterial(int $enrollmentId, int $materialId): BinaryFileResponse|RedirectResponse
    {
        $enrollment = TrainingEnrollment::where('id', $enrollmentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$enrollment->isPaid()) {
            abort(403, 'Akses materi hanya tersedia setelah pembayaran diverifikasi.');
        }

        $material = TrainingMaterial::where('id', $materialId)
            ->where('training_class_id', $enrollment->training_class_id)
            ->firstOrFail();

        if ($material->isPdf() && Storage::disk('local')->exists($material->file_path)) {
            $safeName = Str::slug($material->title) . '.pdf';
            return response()->file(
                Storage::disk('local')->path($material->file_path),
                ['Content-Disposition' => 'inline; filename="' . $safeName . '"']
            );
        }

        if (!empty($material->external_url)) {
            return redirect()->away($material->external_url);
        }

        abort(404, 'File materi tidak ditemukan.');
    }

    /**
     * Create a new custom affiliate code for student.
     */
    public function createAffiliateCode(Request $request): RedirectResponse
    {
        AcademySchemaEnsurer::ensure();

        $user = Auth::user();

        $validated = $request->validate([
            'code' => ['required', 'string', 'min:3', 'max:20', 'alpha_num'],
        ], [
            'code.required' => 'Kode afiliasi wajib diisi.',
            'code.alpha_num' => 'Kode afiliasi hanya boleh huruf dan angka tanpa spasi.',
            'code.min' => 'Kode minimal 3 karakter.',
            'code.max' => 'Kode maksimal 20 karakter.',
        ]);

        $codeUpper = strtoupper($validated['code']);

        $this->ensureAffiliateTableExists();

        if (AffiliateCode::where('user_id', $user->id)->count() >= 5) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'warning',
                'message' => 'Maksimal 5 kode afiliasi per akun pelajar.',
            ]);
        }

        if (AffiliateCode::where('code', $codeUpper)->exists()) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'error',
                'message' => 'Kode afiliasi "' . $codeUpper . '" sudah digunakan. Silakan pilih kode lain.',
            ]);
        }

        $discountPercent = (int) AcademySetting::getValue('affiliate_discount_percent', '5');
        $commissionPercent = (int) AcademySetting::getValue('affiliate_commission_percent', '2');

        AffiliateCode::create([
            'user_id' => $user->id,
            'code' => $codeUpper,
            'discount_percent' => $discountPercent,
            'commission_percent' => $commissionPercent,
            'usage_count' => 0,
            'total_commission' => 0,
            'is_active' => true,
        ]);

        return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
            'type' => 'success',
            'message' => 'Kode afiliasi ' . $codeUpper . ' berhasil dibuat!',
        ]);
    }

    /**
     * Delete an affiliate code owned by student.
     */
    public function deleteAffiliateCode(int $id): RedirectResponse
    {
        $user = Auth::user();

        $affiliate = AffiliateCode::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $count = AffiliateCode::where('user_id', $user->id)->count();
        if ($count <= 1) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'warning',
                'message' => 'Anda harus memiliki minimal 1 kode afiliasi aktif.',
            ]);
        }

        if ($affiliate->usage_count > 0 || $affiliate->total_commission > 0 || $affiliate->enrollments()->exists()) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'warning',
                'message' => 'Kode afiliasi yang sudah pernah digunakan tidak dapat dihapus demi menjaga riwayat transaksi.',
            ]);
        }

        $affiliate->delete();

        return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
            'type' => 'success',
            'message' => 'Kode afiliasi berhasil dihapus.',
        ]);
    }

    /**
     * Request commission withdrawal (recorded in database & managed by admin).
     */
    public function withdrawAffiliate(Request $request): RedirectResponse
    {
        AcademySchemaEnsurer::ensure();

        $user = Auth::user();
        $minWithdrawal = (int) AcademySetting::getValue('affiliate_min_withdrawal', '50000');

        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:' . max(1, $minWithdrawal)],
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder' => ['required', 'string', 'max:100'],
        ], [
            'amount.required' => 'Nominal penarikan wajib diisi.',
            'amount.integer' => 'Nominal penarikan harus berupa angka bulat.',
            'amount.min' => 'Minimal penarikan komisi adalah Rp ' . number_format($minWithdrawal, 0, ',', '.') . '.',
            'bank_name.required' => 'Nama Bank / E-Wallet wajib diisi.',
            'account_number.required' => 'Nomor Rekening wajib diisi.',
            'account_holder.required' => 'Nama Pemilik Rekening wajib diisi.',
        ]);

        return DB::transaction(function () use ($user, $minWithdrawal, $validated) {
            // Lock user row to prevent concurrent double-withdrawals
            User::where('id', $user->id)->lockForUpdate()->first();

            $totalCommission = (int) AffiliateCode::where('user_id', $user->id)->sum('total_commission');
            $withdrawn = (int) AffiliateWithdrawal::where('user_id', $user->id)
                ->where('status', AffiliateWithdrawal::STATUS_PAID)
                ->sum('amount');
            $pending = (int) AffiliateWithdrawal::where('user_id', $user->id)
                ->where('status', AffiliateWithdrawal::STATUS_PENDING)
                ->sum('amount');

            $availableBalance = max(0, $totalCommission - $withdrawn - $pending);

            if ($availableBalance < $minWithdrawal) {
                return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                    'type' => 'warning',
                    'message' => 'Saldo tersedia Anda (Rp ' . number_format($availableBalance, 0, ',', '.') . ') belum mencapai batas minimal Rp ' . number_format($minWithdrawal, 0, ',', '.') . '.',
                ]);
            }

            $requestedAmount = (int) $validated['amount'];
            if ($requestedAmount > $availableBalance) {
                return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                    'type' => 'error',
                    'message' => 'Nominal penarikan melebihi saldo tersedia Anda (Rp ' . number_format($availableBalance, 0, ',', '.') . ').',
                ]);
            }

            AffiliateWithdrawal::create([
                'user_id' => $user->id,
                'amount' => $requestedAmount,
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'account_holder' => $validated['account_holder'],
                'status' => AffiliateWithdrawal::STATUS_PENDING,
            ]);

            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'success',
                'message' => 'Pengajuan penarikan Rp ' . number_format($requestedAmount, 0, ',', '.') . ' berhasil dikirim dan sedang diproses admin.',
            ]);
        });
    }

    /**
     * Update student personal profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:150'],
            'profession' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi (digunakan untuk sertifikat).',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
        ]);

        $user->update($validated);

        return redirect()->route('student.dashboard', ['#profile'])->with('toast', [
            'type' => 'success',
            'message' => 'Data diri berhasil diperbarui!',
        ]);
    }

    /**
     * Update student account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('student.dashboard', ['#profile'])->with('toast', [
                'type' => 'error',
                'message' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('student.dashboard', ['#profile'])->with('toast', [
            'type' => 'success',
            'message' => 'Password berhasil diperbarui!',
        ]);
    }

    /**
     * View & download official certificate (serves uploaded PDF if present, fallback to legacy HTML view).
     */
    public function viewCertificate(int $id): View|BinaryFileResponse
    {
        $certificate = StudentCertificate::with(['user', 'trainingClass'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($certificate->pdf_path) {
            $fullPath = null;
            if (Storage::disk('local')->exists($certificate->pdf_path)) {
                $fullPath = Storage::disk('local')->path($certificate->pdf_path);
            } elseif (Storage::disk('public')->exists($certificate->pdf_path)) {
                $fullPath = Storage::disk('public')->path($certificate->pdf_path);
            }

            if ($fullPath) {
                $filename = $certificate->original_filename ?: ('Sertifikat-' . Str::slug($certificate->certificate_number) . '.pdf');
                return response()->file(
                    $fullPath,
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $filename . '"',
                        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0',
                        'Pragma' => 'no-cache',
                        'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
                    ]
                );
            }
        }

        return view('student.certificate-view', compact('certificate'));
    }

    /**
     * Store ?ref= affiliate code cleanly in session.
     */
    private function captureReferral(Request $request): void
    {
        $ref = $request->query('ref');
        if (!is_string($ref) || trim($ref) === '') {
            return;
        }

        $clean = strtoupper(preg_replace('/[^a-zA-Z0-9_-]/', '', trim($ref)));
        if ($clean !== '') {
            session(['affiliate_ref' => substr($clean, 0, 32)]);
        }
    }

    /**
     * Normalize Indonesian phone/WhatsApp digits for anti-self-referral check.
     */
    private function normalizePhone(?string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', (string) $phone);
        if ($digits === '') {
            return '';
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Ensure the affiliate_codes table exists resiliently.
     */
    private function ensureAffiliateTableExists(): void
    {
        try {
            if (!Schema::hasTable('affiliate_codes')) {
                Schema::create('affiliate_codes', function ($table) {
                    $table->id();
                    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                    $table->string('code', 32)->unique();
                    $table->unsignedInteger('discount_percent')->default(5);
                    $table->unsignedInteger('commission_percent')->default(2);
                    $table->unsignedInteger('usage_count')->default(0);
                    $table->unsignedBigInteger('total_commission')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Ignore if already created concurrently
        }
    }
}
