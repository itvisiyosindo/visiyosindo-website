<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademySetting;
use App\Models\AffiliateCode;
use App\Models\AffiliateWithdrawal;
use App\Models\StudentCertificate;
use App\Models\TrainingClass;
use App\Models\TrainingEnrollment;
use App\Models\TrainingMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $query = $this->buildEnrollmentsQuery($request);
        $enrollments = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => TrainingEnrollment::count(),
            'pending' => TrainingEnrollment::where('status', TrainingEnrollment::STATUS_PENDING)->count(),
            'active' => TrainingEnrollment::where('status', TrainingEnrollment::STATUS_ACTIVE)->count(),
            'completed' => TrainingEnrollment::where('status', TrainingEnrollment::STATUS_COMPLETED)->count(),
        ];

        $classesList = TrainingClass::select('id', 'title', 'batch_name')->get();
        $academySettings = AcademySetting::allSettings();

        return view('dashboard.management.trainings.index', compact('enrollments', 'stats', 'classesList', 'academySettings'));
    }

    /**
     * Export filtered enrollments as UTF-8 BOM CSV for Excel.
     */
    public function exportEnrollments(Request $request): StreamedResponse
    {
        $this->authorizeManager();

        $enrollments = $this->buildEnrollmentsQuery($request)->get();
        $filename = 'peserta-visilab-academy-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($enrollments) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for clean Excel rendering
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No. Invoice',
                'Tanggal Daftar',
                'Nama Peserta',
                'Email',
                'No. WhatsApp',
                'Instansi',
                'Profesi',
                'Program Kelas',
                'Batch',
                'Harga Dasar (Rp)',
                'Diskon (Rp)',
                'Total Tagihan (Rp)',
                'Kode Afiliasi',
                'Komisi Afiliasi (Rp)',
                'Status',
                'No. Sertifikat',
            ]);

            foreach ($enrollments as $row) {
                fputcsv($handle, [
                    $row->effective_invoice_no,
                    $row->created_at?->format('Y-m-d H:i') ?? '',
                    $row->user->name ?? '',
                    $row->user->email ?? '',
                    $row->user->phone ?? '',
                    $row->user->institution ?? '',
                    $row->user->profession ?? '',
                    $row->trainingClass->title ?? '',
                    $row->trainingClass->batch_name ?? '',
                    $row->effective_base_price,
                    $row->discount_amount ?? 0,
                    $row->effective_final_price,
                    $row->affiliateCode->code ?? '',
                    $row->affiliate_commission ?? 0,
                    $row->status_label,
                    $row->certificate->certificate_number ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Preview payment proof uploaded by student.
     */
    public function viewPaymentProof(int $id): BinaryFileResponse
    {
        $this->authorizeManager();

        $enrollment = TrainingEnrollment::findOrFail($id);

        if (!$enrollment->payment_proof_path || !Storage::disk('local')->exists($enrollment->payment_proof_path)) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        return response()->file(Storage::disk('local')->path($enrollment->payment_proof_path));
    }

    /**
     * Approve student enrollment and credit affiliate commission once.
     */
    public function approve(int $id): RedirectResponse
    {
        $this->authorizeManager();

        DB::transaction(function () use ($id) {
            $enrollment = TrainingEnrollment::lockForUpdate()->findOrFail($id);

            $updateData = [
                'status' => TrainingEnrollment::STATUS_ACTIVE,
                'approved_at' => $enrollment->approved_at ?? now(),
                'rejection_reason' => null,
            ];

            // Award affiliate commission only once per enrollment
            if ($enrollment->affiliate_code_id && $enrollment->commission_awarded_at === null) {
                $affiliate = AffiliateCode::lockForUpdate()->find($enrollment->affiliate_code_id);
                if ($affiliate) {
                    $commission = (int) ($enrollment->affiliate_commission ?? 0);
                    if ($commission <= 0 && $enrollment->effective_final_price > 0) {
                        $commissionPercent = (int) AcademySetting::getValue('affiliate_commission_percent', '2');
                        $commission = (int) round($enrollment->effective_final_price * ($commissionPercent / 100));
                        $updateData['affiliate_commission'] = $commission;
                    }

                    $affiliate->increment('usage_count');
                    if ($commission > 0) {
                        $affiliate->increment('total_commission', $commission);
                    }
                    $updateData['commission_awarded_at'] = now();
                }
            }

            $enrollment->update($updateData);
        });

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Status pendaftaran peserta berhasil disetujui (Aktif) dan komisi afiliasi (jika ada) telah dicatat.',
        ]);
    }

    /**
     * Reject or cancel enrollment with optional reason.
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $enrollment = TrainingEnrollment::findOrFail($id);
        $enrollment->update([
            'status' => TrainingEnrollment::STATUS_CANCELLED,
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'warning',
            'message' => 'Pendaftaran peserta berhasil dibatalkan.',
        ]);
    }

    /**
     * Mark training completed and issue/upload certificate PDF.
     */
    public function complete(Request $request, int $id): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'certificate_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'certificate_number' => ['nullable', 'string', 'max:100'],
            'issued_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
        ], [
            'certificate_pdf.mimes' => 'File sertifikat harus berformat PDF.',
            'certificate_pdf.max' => 'Ukuran file PDF sertifikat maksimal 10 MB.',
        ]);

        $enrollment = TrainingEnrollment::with(['user', 'trainingClass', 'certificate'])->findOrFail($id);
        $enrollment->update([
            'status' => TrainingEnrollment::STATUS_COMPLETED,
            'completed_at' => $enrollment->completed_at ?? now(),
        ]);

        $certNumber = !empty($validated['certificate_number'])
            ? trim($validated['certificate_number'])
            : ($enrollment->certificate->certificate_number ?? sprintf('CERT/VISILAB/%s/%s/%04d', date('Y'), date('m'), $enrollment->id));

        $issuedDate = !empty($validated['issued_date'])
            ? $validated['issued_date']
            : ($enrollment->certificate?->issued_date?->toDateString() ?? now()->toDateString());

        $pdfPath = $enrollment->certificate->pdf_path ?? null;
        $originalFilename = $enrollment->certificate->original_filename ?? null;

        if ($request->hasFile('certificate_pdf')) {
            if ($pdfPath && Storage::disk('local')->exists($pdfPath)) {
                Storage::disk('local')->delete($pdfPath);
            }
            $file = $request->file('certificate_pdf');
            $pdfPath = $file->store('trainings/certificates', 'local');
            $originalFilename = $file->getClientOriginalName();
        }

        if ($enrollment->certificate) {
            $enrollment->certificate->update([
                'certificate_number' => $certNumber,
                'recipient_name' => $enrollment->certificate->recipient_name ?: ($enrollment->user->name ?? 'Peserta'),
                'recipient_institution' => $enrollment->certificate->recipient_institution ?: ($enrollment->user->institution ?? null),
                'pdf_path' => $pdfPath,
                'original_filename' => $originalFilename,
                'issued_date' => $issuedDate,
                'notes' => $validated['notes'] ?? $enrollment->certificate->notes,
            ]);
        } else {
            StudentCertificate::create([
                'training_enrollment_id' => $enrollment->id,
                'user_id' => $enrollment->user_id,
                'training_class_id' => $enrollment->training_class_id,
                'certificate_number' => $certNumber,
                'verification_code' => 'VSI-' . strtoupper(Str::random(8)),
                'recipient_name' => $enrollment->user->name ?? 'Peserta',
                'recipient_institution' => $enrollment->user->institution ?? null,
                'pdf_path' => $pdfPath,
                'original_filename' => $originalFilename,
                'issued_date' => $issuedDate,
                'notes' => $validated['notes'] ?? null,
            ]);
        }

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => $request->hasFile('certificate_pdf')
                ? 'Peserta diluluskan dan file sertifikat PDF berhasil diunggah ke akun peserta!'
                : 'Peserta berhasil diluluskan! Anda dapat mengunggah file PDF sertifikat sekarang atau melalui menu Sertifikat Kelulusan.',
        ]);
    }

    /**
     * 2. Display listing of all training classes (Katalog & Kelola Kelas).
     */
    public function classesIndex(Request $request): View
    {
        $this->authorizeManager();

        $query = TrainingClass::withCount(['enrollments', 'materials'])->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('batch_name', 'like', "%{$search}%")
                  ->orWhere('instructor', 'like', "%{$search}%");
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
            'total_students' => TrainingEnrollment::where('status', '!=', TrainingEnrollment::STATUS_CANCELLED)->count(),
        ];

        return view('dashboard.management.trainings.classes', compact('classes', 'stats'));
    }

    /**
     * Store a newly created training class.
     */
    public function classesStore(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $this->sanitizeClassInputs($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'batch_name' => ['required', 'string', 'max:100'],
            'instructor' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota' => ['nullable', 'integer', 'min:1'],
            'registration_deadline' => ['nullable', 'date'],
            'duration' => ['nullable', 'string', 'max:100'],
            'schedule' => ['nullable', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:255'],
            'delivery_mode' => ['nullable', 'in:online,offline,hybrid'],
            'whatsapp_group_link' => ['nullable', 'string', 'max:255'],
            'materials_link' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'syllabus' => ['nullable', 'string'],
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
            'instructor' => $validated['instructor'] ?? null,
            'price' => (int) $validated['price'],
            'quota' => !empty($validated['quota']) ? (int) $validated['quota'] : null,
            'registration_deadline' => $validated['registration_deadline'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'location' => $validated['location'] ?? null,
            'delivery_mode' => $validated['delivery_mode'] ?? 'online',
            'whatsapp_group_link' => $validated['whatsapp_group_link'] ?? null,
            'materials_link' => $validated['materials_link'] ?? null,
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'syllabus' => $validated['syllabus'] ?? null,
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
        $this->sanitizeClassInputs($request);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'batch_name' => ['required', 'string', 'max:100'],
            'instructor' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quota' => ['nullable', 'integer', 'min:1'],
            'registration_deadline' => ['nullable', 'date'],
            'duration' => ['nullable', 'string', 'max:100'],
            'schedule' => ['nullable', 'string', 'max:150'],
            'location' => ['nullable', 'string', 'max:255'],
            'delivery_mode' => ['nullable', 'in:online,offline,hybrid'],
            'whatsapp_group_link' => ['nullable', 'string', 'max:255'],
            'materials_link' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'description' => ['nullable', 'string'],
            'syllabus' => ['nullable', 'string'],
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
            'instructor' => $validated['instructor'] ?? null,
            'price' => (int) $validated['price'],
            'quota' => !empty($validated['quota']) ? (int) $validated['quota'] : null,
            'registration_deadline' => $validated['registration_deadline'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'schedule' => $validated['schedule'] ?? null,
            'location' => $validated['location'] ?? null,
            'delivery_mode' => $validated['delivery_mode'] ?? 'online',
            'whatsapp_group_link' => $validated['whatsapp_group_link'] ?? null,
            'materials_link' => $validated['materials_link'] ?? null,
            'image' => $imagePath,
            'description' => $validated['description'] ?? null,
            'syllabus' => $validated['syllabus'] ?? null,
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
     * Manage materials (PDF / Video / Links) for a training class.
     */
    public function materialsIndex(int $classId): View
    {
        $this->authorizeManager();

        $trainingClass = TrainingClass::with('materials')->findOrFail($classId);

        return view('dashboard.management.trainings.materials', compact('trainingClass'));
    }

    /**
     * Store a new material for a training class.
     */
    public function materialsStore(Request $request, int $classId): RedirectResponse
    {
        $this->authorizeManager();

        $trainingClass = TrainingClass::findOrFail($classId);

        if ($request->filled('external_url')) {
            $url = trim($request->input('external_url'));
            if (!preg_match('~^(?:f|ht)tps?://~i', $url)) {
                $request->merge(['external_url' => 'https://' . $url]);
            }
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:pdf,video,link'],
            'file' => ['required_if:type,pdf', 'nullable', 'file', 'mimes:pdf', 'max:20480'],
            'external_url' => ['required_unless:type,pdf', 'nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'Judul materi wajib diisi.',
            'file.required_if' => 'File PDF wajib diunggah untuk materi bertipe PDF.',
            'file.mimes' => 'File materi harus berformat PDF.',
            'file.max' => 'Ukuran file PDF maksimal 20 MB.',
            'external_url.required_unless' => 'Link URL wajib diisi untuk materi bertipe Video atau Tautan.',
        ]);

        $filePath = null;
        if ($validated['type'] === 'pdf' && $request->hasFile('file')) {
            $filePath = $request->file('file')->store('trainings/materials', 'local');
        }

        TrainingMaterial::create([
            'training_class_id' => $trainingClass->id,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'file_path' => $filePath,
            'external_url' => $validated['type'] !== 'pdf' ? ($validated['external_url'] ?? null) : null,
            'description' => $validated['description'] ?? null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ]);

        return redirect()->route('dashboard.trainings.materials', $trainingClass->id)->with('toast', [
            'type' => 'success',
            'message' => 'Materi kelas berhasil ditambahkan!',
        ]);
    }

    /**
     * Delete a training material.
     */
    public function materialsDestroy(int $classId, int $materialId): RedirectResponse
    {
        $this->authorizeManager();

        $material = TrainingMaterial::where('id', $materialId)
            ->where('training_class_id', $classId)
            ->firstOrFail();

        if ($material->file_path && Storage::disk('local')->exists($material->file_path)) {
            Storage::disk('local')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('dashboard.trainings.materials', $classId)->with('toast', [
            'type' => 'success',
            'message' => 'Materi berhasil dihapus.',
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
                  ->orWhere('recipient_name', 'like', "%{$search}%")
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
     * Upload or replace official certificate PDF for a student certificate record.
     */
    public function uploadCertificatePdf(Request $request, int $id): RedirectResponse
    {
        $this->authorizeManager();

        $certificate = StudentCertificate::with('user')->findOrFail($id);

        $validated = $request->validate([
            'certificate_pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'certificate_number' => ['nullable', 'string', 'max:100'],
            'issued_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
        ], [
            'certificate_pdf.required' => 'File PDF sertifikat wajib dipilih.',
            'certificate_pdf.mimes' => 'File sertifikat harus berformat PDF.',
            'certificate_pdf.max' => 'Ukuran file PDF sertifikat maksimal 10 MB.',
        ]);

        if ($certificate->pdf_path && Storage::disk('local')->exists($certificate->pdf_path)) {
            Storage::disk('local')->delete($certificate->pdf_path);
        }

        $file = $request->file('certificate_pdf');
        $pdfPath = $file->store('trainings/certificates', 'local');

        $certificate->update([
            'pdf_path' => $pdfPath,
            'original_filename' => $file->getClientOriginalName(),
            'certificate_number' => !empty($validated['certificate_number']) ? trim($validated['certificate_number']) : $certificate->certificate_number,
            'issued_date' => !empty($validated['issued_date']) ? $validated['issued_date'] : $certificate->issued_date,
            'notes' => $validated['notes'] ?? $certificate->notes,
            'recipient_name' => $certificate->recipient_name ?: ($certificate->user->name ?? 'Peserta'),
            'recipient_institution' => $certificate->recipient_institution ?: ($certificate->user->institution ?? null),
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'File sertifikat PDF resmi berhasil diunggah!',
        ]);
    }

    /**
     * Preview / download certificate PDF (or fallback HTML view) from Admin Dashboard.
     */
    public function downloadCertificate(int $id): BinaryFileResponse|View
    {
        $this->authorizeManager();

        $certificate = StudentCertificate::with(['user', 'trainingClass'])->findOrFail($id);

        if ($certificate->pdf_path) {
            if (Storage::disk('local')->exists($certificate->pdf_path)) {
                $filename = $certificate->original_filename ?: ('Sertifikat-' . Str::slug($certificate->certificate_number) . '.pdf');
                return response()->file(
                    Storage::disk('local')->path($certificate->pdf_path),
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    ]
                );
            }
            if (Storage::disk('public')->exists($certificate->pdf_path)) {
                $filename = $certificate->original_filename ?: ('Sertifikat-' . Str::slug($certificate->certificate_number) . '.pdf');
                return response()->file(
                    Storage::disk('public')->path($certificate->pdf_path),
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="' . $filename . '"',
                    ]
                );
            }
        }

        return view('student.certificate-view', compact('certificate'));
    }

    /**
     * 4. Display list of all student affiliate codes & withdrawal requests.
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

        $withdrawals = collect();
        $withdrawalStats = [
            'pending_count' => 0,
            'pending_amount' => 0,
            'paid_amount' => 0,
        ];

        if (Schema::hasTable('affiliate_withdrawals')) {
            $withdrawals = AffiliateWithdrawal::with(['user', 'processor'])->latest()->get();
            $withdrawalStats = [
                'pending_count' => AffiliateWithdrawal::where('status', AffiliateWithdrawal::STATUS_PENDING)->count(),
                'pending_amount' => (int) AffiliateWithdrawal::where('status', AffiliateWithdrawal::STATUS_PENDING)->sum('amount'),
                'paid_amount' => (int) AffiliateWithdrawal::where('status', AffiliateWithdrawal::STATUS_PAID)->sum('amount'),
            ];
        }

        $academySettings = AcademySetting::allSettings();

        return view('dashboard.management.trainings.affiliates', compact(
            'affiliates',
            'stats',
            'withdrawals',
            'withdrawalStats',
            'academySettings'
        ));
    }

    /**
     * Approve & mark affiliate withdrawal request as transferred.
     */
    public function approveWithdrawal(Request $request, int $id): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $withdrawal = AffiliateWithdrawal::findOrFail($id);
        $withdrawal->update([
            'status' => AffiliateWithdrawal::STATUS_PAID,
            'admin_notes' => $validated['admin_notes'] ?? 'Komisi telah ditransfer ke rekening tujuan.',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Penarikan komisi berhasil ditandai Sudah Ditransfer.',
        ]);
    }

    /**
     * Reject affiliate withdrawal request (balance automatically restored).
     */
    public function rejectWithdrawal(Request $request, int $id): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $withdrawal = AffiliateWithdrawal::findOrFail($id);
        $withdrawal->update([
            'status' => AffiliateWithdrawal::STATUS_REJECTED,
            'admin_notes' => $validated['admin_notes'] ?? 'Pengajuan penarikan ditolak oleh admin.',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'warning',
            'message' => 'Pengajuan penarikan komisi ditolak dan saldo dikembalikan ke pelajar.',
        ]);
    }

    /**
     * 5. Academy Settings page (WhatsApp, Bank Account, Affiliate rates).
     */
    public function settingsIndex(): View
    {
        $this->authorizeManager();

        $settings = AcademySetting::allSettings();

        return view('dashboard.management.trainings.settings', compact('settings'));
    }

    /**
     * Save Academy Settings.
     */
    public function settingsUpdate(Request $request): RedirectResponse
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'admin_whatsapp' => ['required', 'string', 'max:30'],
            'bank_name' => ['required', 'string', 'max:100'],
            'bank_account_number' => ['required', 'string', 'max:100'],
            'bank_account_holder' => ['required', 'string', 'max:150'],
            'affiliate_discount_percent' => ['required', 'integer', 'min:0', 'max:50'],
            'affiliate_commission_percent' => ['required', 'integer', 'min:0', 'max:50'],
            'affiliate_min_withdrawal' => ['required', 'integer', 'min:0'],
        ], [
            'admin_whatsapp.required' => 'Nomor WhatsApp Admin wajib diisi.',
            'bank_name.required' => 'Nama Bank wajib diisi.',
            'bank_account_number.required' => 'Nomor Rekening wajib diisi.',
            'bank_account_holder.required' => 'Nama Pemilik Rekening wajib diisi.',
        ]);

        // Normalize WhatsApp digits (convert leading 08 to 628)
        $wa = preg_replace('/[^0-9]/', '', $validated['admin_whatsapp']);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        $validated['admin_whatsapp'] = $wa;

        foreach ($validated as $key => $val) {
            AcademySetting::setValue($key, (string) $val);
        }

        return redirect()->route('dashboard.trainings.settings')->with('toast', [
            'type' => 'success',
            'message' => 'Pengaturan Visilab Academy berhasil disimpan!',
        ]);
    }

    /**
     * Shared enrollment query builder for index & CSV export.
     */
    private function buildEnrollmentsQuery(Request $request)
    {
        $query = TrainingEnrollment::with(['user', 'trainingClass', 'certificate', 'affiliateCode'])
            ->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($classId = $request->get('training_class_id')) {
            $query->where('training_class_id', $classId);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%")
                         ->orWhere('institution', 'like', "%{$search}%");
                  })->orWhereHas('trainingClass', function ($tq) use ($search) {
                      $tq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        return $query;
    }

    /**
     * Sanitize price, quota, and URL inputs for training class store/update.
     */
    private function sanitizeClassInputs(Request $request): void
    {
        if ($request->has('price')) {
            $rawPrice = preg_replace('/[^0-9]/', '', (string) $request->input('price', 0));
            $request->merge(['price' => $rawPrice === '' ? 0 : (int) $rawPrice]);
        }

        if ($request->has('quota') && trim((string) $request->input('quota')) === '') {
            $request->merge(['quota' => null]);
        }

        if ($request->has('registration_deadline') && trim((string) $request->input('registration_deadline')) === '') {
            $request->merge(['registration_deadline' => null]);
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
    }
}
