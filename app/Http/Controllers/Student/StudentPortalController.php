<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AffiliateCode;
use App\Models\StudentCertificate;
use App\Models\TrainingClass;
use App\Models\TrainingEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentPortalController extends Controller
{
    /**
     * Display student portal dashboard with left sidebar navigation:
     * (Overview, Kelas, Daftar Kelas, Afiliasi, Invoice, Profil & Akun).
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        // Enrollments with class & certificate
        $enrollments = $user->enrollments()
            ->with(['trainingClass', 'certificate'])
            ->latest()
            ->get();

        // Certificates
        $certificates = $user->studentCertificates()
            ->with('trainingClass')
            ->latest()
            ->get();

        // Available classes currently open for registration
        $availableClasses = TrainingClass::where('is_active', true)->latest()->get();
        $enrolledClassIds = $enrollments->pluck('training_class_id')->toArray();

        // Ensure affiliate_codes table exists (auto-resilient if migration not yet run)
        $this->ensureAffiliateTableExists();

        // Fetch or initialize student's affiliate codes
        $affiliateCodes = collect();
        try {
            $affiliateCodes = AffiliateCode::where('user_id', $user->id)->latest()->get();

            if ($affiliateCodes->isEmpty()) {
                // Auto-generate a default code for the student
                $cleanName = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $user->name) ?: 'PELAJAR', 0, 5));
                $generatedCode = 'VISI-' . $cleanName . rand(100, 999);

                // Check uniqueness
                while (AffiliateCode::where('code', $generatedCode)->exists()) {
                    $generatedCode = 'VISI-' . $cleanName . rand(100, 999);
                }

                $defaultCode = AffiliateCode::create([
                    'user_id' => $user->id,
                    'code' => $generatedCode,
                    'discount_percent' => 10,
                    'commission_percent' => 20,
                    'usage_count' => 0,
                    'total_commission' => 0,
                    'is_active' => true,
                ]);

                $affiliateCodes = collect([$defaultCode]);
            }
        } catch (\Throwable $e) {
            // Fallback object in memory if DB error
            $affiliateCodes = collect([
                (object) [
                    'id' => 1,
                    'code' => 'VISI-' . strtoupper(substr($user->name, 0, 4)) . '10',
                    'discount_percent' => 10,
                    'commission_percent' => 20,
                    'usage_count' => 0,
                    'total_commission' => 0,
                    'is_active' => true,
                ]
            ]);
        }

        $affiliateStats = [
            'balance' => $affiliateCodes->sum('total_commission'),
            'this_month' => 0,
            'withdrawn' => 0,
            'total' => $affiliateCodes->sum('total_commission'),
        ];

        // Format Invoices list from enrollments
        $invoices = $enrollments->map(function ($enrollment) {
            $date = $enrollment->created_at ?? now();
            $invNo = 'INV-VYM-' . $date->format('Ym') . '-' . str_pad($enrollment->id, 4, '0', STR_PAD_LEFT);
            $amount = $enrollment->trainingClass->price ?? 0;
            $isPaid = in_array($enrollment->status, [TrainingEnrollment::STATUS_ACTIVE, TrainingEnrollment::STATUS_COMPLETED], true);

            return (object) [
                'id' => $enrollment->id,
                'invoice_no' => $invNo,
                'class_title' => $enrollment->trainingClass->title ?? 'Pelatihan Medikal',
                'batch_name' => $enrollment->trainingClass->batch_name ?? 'Batch Reguler',
                'amount' => $amount,
                'formatted_amount' => $amount > 0 ? 'Rp ' . number_format($amount, 0, ',', '.') : 'Gratis',
                'date' => $date->translatedFormat('d F Y, H:i'),
                'raw_date' => $date,
                'status' => $enrollment->status,
                'status_label' => $enrollment->status_label,
                'is_paid' => $isPaid,
                'enrollment' => $enrollment,
            ];
        });

        // Visilab WhatsApp contact
        $adminWhatsApp = '6281261457547';

        return view('student.dashboard', compact(
            'user',
            'enrollments',
            'certificates',
            'availableClasses',
            'enrolledClassIds',
            'affiliateCodes',
            'affiliateStats',
            'invoices',
            'adminWhatsApp'
        ));
    }

    /**
     * Display catalogue of available training classes (public page).
     */
    public function classes(): View
    {
        $classes = TrainingClass::where('is_active', true)->latest()->get();
        $enrolledClassIds = Auth::user()
            ? Auth::user()->enrollments()->pluck('training_class_id')->toArray()
            : [];

        return view('student.classes', compact('classes', 'enrolledClassIds'));
    }

    /**
     * Enroll in a training class.
     */
    public function enroll(Request $request, int $id): RedirectResponse
    {
        $trainingClass = TrainingClass::where('is_active', true)->findOrFail($id);
        $user = Auth::user();

        $existing = TrainingEnrollment::where('user_id', $user->id)
            ->where('training_class_id', $trainingClass->id)
            ->first();

        if ($existing) {
            return redirect()->route('student.dashboard', ['#classes'])->with('toast', [
                'type' => 'info',
                'message' => 'Anda sudah terdaftar di kelas ' . $trainingClass->title . '.',
            ]);
        }

        TrainingEnrollment::create([
            'user_id' => $user->id,
            'training_class_id' => $trainingClass->id,
            'status' => TrainingEnrollment::STATUS_PENDING,
            'payment_method' => 'manual_wa',
        ]);

        return redirect()->route('student.dashboard', ['#classes'])->with('toast', [
            'type' => 'success',
            'message' => 'Berhasil mendaftar kelas! Silakan lakukan konfirmasi pembayaran via WhatsApp.',
        ]);
    }

    /**
     * Create a new custom affiliate code for student.
     */
    public function createAffiliateCode(Request $request): RedirectResponse
    {
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

        if (AffiliateCode::where('code', $codeUpper)->exists()) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'error',
                'message' => 'Kode afiliasi "' . $codeUpper . '" sudah digunakan. Silakan pilih kode lain.',
            ]);
        }

        AffiliateCode::create([
            'user_id' => $user->id,
            'code' => $codeUpper,
            'discount_percent' => 10,
            'commission_percent' => 20,
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

        // Optional check: keep at least 1 code
        $count = AffiliateCode::where('user_id', $user->id)->count();
        if ($count <= 1) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'warning',
                'message' => 'Anda harus memiliki minimal 1 kode afiliasi aktif.',
            ]);
        }

        $affiliate->delete();

        return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
            'type' => 'success',
            'message' => 'Kode afiliasi berhasil dihapus.',
        ]);
    }

    /**
     * Request commission withdrawal.
     */
    public function withdrawAffiliate(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $totalCommission = AffiliateCode::where('user_id', $user->id)->sum('total_commission');

        $validated = $request->validate([
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder' => ['required', 'string', 'max:100'],
        ], [
            'bank_name.required' => 'Nama Bank wajib diisi.',
            'account_number.required' => 'Nomor Rekening wajib diisi.',
            'account_holder.required' => 'Nama Pemilik Rekening wajib diisi.',
        ]);

        if ($totalCommission < 50000) {
            return redirect()->route('student.dashboard', ['#affiliate'])->with('toast', [
                'type' => 'warning',
                'message' => 'Minimal penarikan komisi adalah Rp 50.000. Saldo Anda saat ini belum mencukupi.',
            ]);
        }

        // WhatsApp redirect message for payout confirmation
        $waMessage = rawurlencode(
            "Halo Tim Keuangan Visilab Academy,\n\n" .
            "Saya ingin mengajukan penarikan komisi afiliasi:\n" .
            "- Nama Akun: " . $user->name . "\n" .
            "- Email: " . $user->email . "\n" .
            "- Jumlah Saldo: Rp " . number_format($totalCommission, 0, ',', '.') . "\n" .
            "- Bank: " . $validated['bank_name'] . "\n" .
            "- No. Rekening: " . $validated['account_number'] . "\n" .
            "- Atas Nama: " . $validated['account_holder'] . "\n\n" .
            "Mohon untuk diproses. Terima kasih!"
        );

        return redirect()->away('https://wa.me/6281261457547?text=' . $waMessage);
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
     * View & print/download official certificate.
     */
    public function viewCertificate(int $id): View
    {
        $certificate = StudentCertificate::with(['user', 'trainingClass'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('student.certificate-view', compact('certificate'));
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
                    $table->unsignedInteger('discount_percent')->default(10);
                    $table->unsignedInteger('commission_percent')->default(20);
                    $table->unsignedInteger('usage_count')->default(0);
                    $table->unsignedBigInteger('total_commission')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            // Ignore error if permission fails or already created concurrently
        }
    }
}
