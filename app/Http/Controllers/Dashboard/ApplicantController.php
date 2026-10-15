<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    /**
     * Display applicants for a specific vacancy.
     */
    public function index(Request $request, string $encryptedVacancyId): View
    {
        $vacancyId = EncryptedRouteHelper::decryptOrFail($encryptedVacancyId);
        $vacancy = JobVacancy::findOrFail($vacancyId);

        $query = JobApplication::where('job_vacancy_id', $vacancyId);

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Recommendation filter
        if ($recommendation = $request->get('recommendation')) {
            $query->where('recommendation', $recommendation);
        }

        // Sort by parameter (default: match_score)
        $sortBy = $request->get('sort', 'score'); // 'score' or 'date'
        if ($sortBy === 'score') {
            $query->orderBy('match_score', 'desc')->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $applicants = $query->paginate(15)
            ->withQueryString();

        $statusCounts = JobApplication::where('job_vacancy_id', $vacancyId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $recommendationCounts = JobApplication::where('job_vacancy_id', $vacancyId)
            ->selectRaw('recommendation, COUNT(*) as count')
            ->groupBy('recommendation')
            ->pluck('count', 'recommendation')
            ->toArray();

        return view('dashboard.management.careers.applicants.index', compact('vacancy', 'applicants', 'statusCounts', 'recommendationCounts'));
    }

    /**
     * Display a specific applicant detail.
     */
    public function show(string $encryptedVacancyId, string $encryptedId): View
    {
        $vacancyId = EncryptedRouteHelper::decryptOrFail($encryptedVacancyId);
        $vacancy = JobVacancy::findOrFail($vacancyId);

        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $applicant = JobApplication::where('job_vacancy_id', $vacancyId)->findOrFail($id);

        return view('dashboard.management.careers.applicants.show', compact('vacancy', 'applicant'));
    }

    /**
     * Update applicant status.
     */
    public function updateStatus(Request $request, string $encryptedVacancyId, string $encryptedId): JsonResponse
    {
        $vacancyId = EncryptedRouteHelper::decryptOrFail($encryptedVacancyId);
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);

        $applicant = JobApplication::where('job_vacancy_id', $vacancyId)->findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewed,shortlisted,interview,accepted,rejected'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ]);

        $applicant->update($validated);

        return response()->json([
            'success'      => true,
            'message'      => 'Status pelamar berhasil diperbarui.',
            'status'       => $applicant->status,
            'status_label' => $applicant->status_label,
            'status_color' => $applicant->status_color,
        ]);
    }

    /**
     * Delete an applicant.
     */
    public function destroy(string $encryptedVacancyId, string $encryptedId)
    {
        $vacancyId = EncryptedRouteHelper::decryptOrFail($encryptedVacancyId);
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);

        $applicant = JobApplication::where('job_vacancy_id', $vacancyId)->findOrFail($id);

        // Delete uploaded files
        if ($applicant->cv_path) Storage::disk('public')->delete($applicant->cv_path);
        if ($applicant->transcript_path) Storage::disk('public')->delete($applicant->transcript_path);
        if ($applicant->ijazah_path) Storage::disk('public')->delete($applicant->ijazah_path);

        $applicant->delete();

        return redirect()
            ->route('dashboard.careers.applicants.index', $encryptedVacancyId)
            ->with('success', 'Data pelamar berhasil dihapus.');
    }

    /**
     * Preview applicant document (secure, authenticated).
     */
    public function previewDocument(string $encryptedVacancyId, string $encryptedId, string $type)
    {
        $vacancyId = EncryptedRouteHelper::decryptOrFail($encryptedVacancyId);
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);

        $applicant = JobApplication::where('job_vacancy_id', $vacancyId)->findOrFail($id);

        $pathField = $type . '_path';
        $path = $applicant->{$pathField};

        $disk = Storage::disk('public');

        if (!$path || !$disk->exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        // Return file response with inline content disposition for preview
        $fullPath = $disk->path($path);
        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    /**
     * Download applicant document.
     */
    public function downloadDocument(string $encryptedVacancyId, string $encryptedId, string $type)
    {
        $vacancyId = EncryptedRouteHelper::decryptOrFail($encryptedVacancyId);
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);

        $applicant = JobApplication::where('job_vacancy_id', $vacancyId)->findOrFail($id);

        $pathField = $type . '_path';
        $path = $applicant->{$pathField};

        $disk = Storage::disk('public');

        if (!$path || !$disk->exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $fullPath = $disk->path($path);
        $fileName = $applicant->full_name . '_' . $type . '.' . pathinfo($path, PATHINFO_EXTENSION);
        return response()->download($fullPath, $fileName);
    }
}
