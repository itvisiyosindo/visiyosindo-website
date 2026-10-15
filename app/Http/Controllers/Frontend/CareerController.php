<?php

namespace App\Http\Controllers\Frontend;

use App\Constants\Permission as PermissionConstants;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use App\Notifications\NewJobApplicationNotification;
use App\Services\ApplicationScreeningService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class CareerController extends Controller
{
    /**
     * Display career listing page.
     */
    public function index(): View
    {
        $vacancies = JobVacancy::active()
            ->notExpired()
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $departments = $vacancies->pluck('department')->unique()->sort()->values();

        // Get flyer images from featured/active vacancies that have flyer_image
        $flyerImages = $vacancies->whereNotNull('flyer_image')
            ->pluck('flyer_image')
            ->map(fn($path) => asset('storage/' . $path))
            ->values()
            ->toArray();

        // Prepare jobs data for Alpine.js
        $jobsData = $vacancies->map(function ($v) {
            return [
                'id'         => $v->id,
                'slug'       => $v->slug,
                'title'      => $v->title,
                'department' => $v->department,
                'type'       => $v->type,
                'location'   => $v->location,
                'experience' => $v->experience ?? '-',
                'skills'     => $v->skills ?? [],
                'is_featured' => $v->is_featured,
                'deadline'   => $v->deadline ? $v->deadline->format('d M Y') : null,
            ];
        })->values()->toArray();

        $departmentsData = collect([['id' => 'all', 'name' => 'Semua']])
            ->merge($departments->map(fn($d) => ['id' => $d, 'name' => $d]))
            ->values()
            ->toArray();

        return view('pages.karir', compact('jobsData', 'departmentsData', 'flyerImages'));
    }

    /**
     * Display career detail page.
     */
    public function show(string $slug): View
    {
        $vacancy = JobVacancy::active()
            ->notExpired()
            ->where('slug', $slug)
            ->firstOrFail();

        $jobData = [
            'id'               => $vacancy->id,
            'slug'             => $vacancy->slug,
            'title'            => $vacancy->title,
            'department'       => $vacancy->department,
            'type'             => $vacancy->type,
            'location'         => $vacancy->location,
            'experience'       => $vacancy->experience ?? '-',
            'education'        => $vacancy->education ?? '-',
            'salary_range'     => $vacancy->salary_range,
            'postedDate'       => $vacancy->created_at->translatedFormat('d F Y'),
            'deadline'         => $vacancy->deadline ? $vacancy->deadline->translatedFormat('d F Y') : null,
            'skills'           => $vacancy->skills ?? [],
            'description'      => $vacancy->description ?? '',
            'responsibilities' => $vacancy->responsibilities ?? [],
            'requirements'     => $vacancy->requirements ?? [],
            'benefits'         => $vacancy->benefits ?? [],
        ];

        // Get related jobs (same department, excluding current)
        $relatedJobs = JobVacancy::active()
            ->notExpired()
            ->where('department', $vacancy->department)
            ->where('id', '!=', $vacancy->id)
            ->limit(3)
            ->get()
            ->map(function ($v) {
                return [
                    'slug'       => $v->slug,
                    'title'      => $v->title,
                    'department' => $v->department,
                    'type'       => $v->type,
                    'location'   => $v->location,
                ];
            })->values()->toArray();

        return view('pages.karir-detail', compact('jobData', 'relatedJobs'));
    }

    /**
     * Handle job application submission.
     */
    public function apply(Request $request, ApplicationScreeningService $screeningService): JsonResponse
    {
        $validated = $request->validate([
            'job_vacancy_id'  => ['required', 'exists:job_vacancies,id'],
            'full_name'       => ['required', 'string', 'max:150'],
            'email'           => ['required', 'email', 'max:150'],
            'phone'           => ['required', 'string', 'max:30'],
            'birth_date'      => ['required', 'date'],
            'address'         => ['required', 'string'],
            'education'       => ['required', 'string', 'max:100'],
            'major'           => ['required', 'string', 'max:150'],
            'institution'     => ['required', 'string', 'max:200'],
            'graduation_year' => ['required', 'string', 'max:10'],
            'work_experience' => ['nullable', 'string'],
            'last_job'        => ['nullable', 'string', 'max:200'],
            'cv'              => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'transcript'      => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:3072'],
            'ijazah'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:3072'],
        ], [
            'full_name.required'  => 'Nama lengkap wajib diisi.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'phone.required'      => 'No. telepon wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'address.required'    => 'Alamat wajib diisi.',
            'education.required'  => 'Pendidikan wajib diisi.',
            'major.required'      => 'Jurusan wajib diisi.',
            'institution.required'=> 'Institusi wajib diisi.',
            'graduation_year.required' => 'Tahun lulus wajib diisi.',
            'cv.required'         => 'CV wajib diunggah.',
            'cv.mimes'            => 'CV harus berformat PDF, DOC, atau DOCX.',
            'cv.max'              => 'Ukuran CV maksimal 5MB.',
            'transcript.required' => 'Transkrip nilai wajib diunggah.',
            'transcript.mimes'    => 'Transkrip harus berformat PDF, JPG, JPEG, atau PNG.',
            'transcript.max'      => 'Ukuran transkrip maksimal 3MB.',
            'ijazah.mimes'        => 'Ijazah harus berformat PDF, JPG, JPEG, atau PNG.',
            'ijazah.max'          => 'Ukuran Ijazah maksimal 3MB.',
        ]);

        // Check if vacancy is still open
        $vacancy = JobVacancy::active()->notExpired()->find($validated['job_vacancy_id']);
        if (!$vacancy) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan ini sudah tidak tersedia.',
            ], 422);
        }

        // Check for duplicate application (same email + same vacancy)
        $existingApplication = JobApplication::where('job_vacancy_id', $validated['job_vacancy_id'])
            ->where('email', $validated['email'])
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah pernah melamar pada posisi ini.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Upload files to storage
            $cvPath = $request->file('cv')->store('applications/cv', 'public');
            $transcriptPath = $request->file('transcript')->store('applications/transcripts', 'public');
            $ijazahPath = $request->hasFile('ijazah')
                ? $request->file('ijazah')->store('applications/ijazah', 'public')
                : null;

            // Create application
            $application = JobApplication::create([
                'job_vacancy_id'  => $validated['job_vacancy_id'],
                'full_name'       => $validated['full_name'],
                'email'           => $validated['email'],
                'phone'           => $validated['phone'],
                'birth_date'      => $validated['birth_date'],
                'address'         => $validated['address'],
                'education'       => $validated['education'],
                'major'           => $validated['major'],
                'institution'     => $validated['institution'],
                'graduation_year' => $validated['graduation_year'],
                'work_experience' => $validated['work_experience'] ?? null,
                'last_job'        => $validated['last_job'] ?? null,
                'cv_path'         => $cvPath,
                'transcript_path' => $transcriptPath,
                'ijazah_path'     => $ijazahPath,
                'status'          => 'pending',
            ]);

            // 🎯 AUTO-SCREENING: Calculate match scores automatically
            $screeningResult = $screeningService->screenApplication($application);
            
            // Update application with screening results
            $application->update([
                'match_score'        => $screeningResult['match_score'],
                'education_match'    => $screeningResult['education_match'],
                'major_match'        => $screeningResult['major_match'],
                'skill_match'        => $screeningResult['skill_match'],
                'experience_match'   => $screeningResult['experience_match'],
                'recommendation'     => $screeningResult['recommendation'],
                'screening_details'  => $screeningResult['screening_details'],
                'screened_at'        => $screeningResult['screened_at'],
            ]);

            // Push in-app notification to HR/admin users.
            $notificationRecipients = User::query()
                ->where('is_active', true)
                ->get()
                ->filter(function (User $user): bool {
                    if (!$user->notificationPreference('job_applications', true)) {
                        return false;
                    }

                    return $user->isAdmin() || $user->hasPermission(PermissionConstants::APPLICANT_VIEW);
                });

            if ($notificationRecipients->isNotEmpty()) {
                try {
                    Notification::send(
                        $notificationRecipients,
                        new NewJobApplicationNotification($application->fresh()->loadMissing('vacancy'))
                    );
                } catch (\Throwable $notificationError) {
                    Log::warning('Failed to dispatch in-app job application notification', [
                        'application_id' => $application->id,
                        'error' => $notificationError->getMessage(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Lamaran Anda berhasil dikirim! Sistem kami telah memproses aplikasi Anda dan HRD akan segera menghubungi.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Job Application Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.',
            ], 500);
        }
    }
}
