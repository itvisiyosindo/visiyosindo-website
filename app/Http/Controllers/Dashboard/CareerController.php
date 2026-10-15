<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CareerController extends Controller
{
    /**
     * Display a listing of job vacancies.
     */
    public function index(Request $request): View
    {
        $query = JobVacancy::withCount('applications');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Department filter
        if ($department = $request->get('department')) {
            $query->where('department', $department);
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $vacancies = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $departments = JobVacancy::distinct()->pluck('department')->filter()->sort()->values();

        return view('dashboard.management.careers.index', compact('vacancies', 'departments'));
    }

    /**
     * Show the form for creating a new vacancy.
     */
    public function create(): View
    {
        return view('dashboard.management.careers.form');
    }

    /**
     * Store a newly created vacancy in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateVacancy($request);

        DB::beginTransaction();
        try {
            // Handle flyer image upload
            $flyerPath = null;
            if ($request->hasFile('flyer_image')) {
                $flyerPath = $request->file('flyer_image')->store('careers/flyers', 'public');
            }

            JobVacancy::create([
                'title'            => $validated['title'],
                'slug'             => !empty($validated['slug']) ? $validated['slug'] : \Illuminate\Support\Str::slug($validated['title']),
                'department'       => $validated['department'],
                'location'         => $validated['location'],
                'type'             => $validated['type'],
                'experience'       => $validated['experience'] ?? null,
                'education'        => $validated['education'] ?? null,
                'salary_range'     => $validated['salary_range'] ?? null,
                'description'      => $validated['description'] ?? null,
                'responsibilities' => $this->parseJsonField($validated['responsibilities'] ?? null),
                'requirements'     => $this->parseJsonField($validated['requirements'] ?? null),
                'benefits'         => $this->parseJsonField($validated['benefits'] ?? null),
                'skills'           => $this->parseJsonField($validated['skills'] ?? null),
                'flyer_image'      => $flyerPath,
                'is_active'        => $request->boolean('is_active'),
                'is_featured'      => $request->boolean('is_featured'),
                'deadline'         => $validated['deadline'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('dashboard.careers.index')
                ->with('success', 'Lowongan kerja berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified vacancy.
     */
    public function show(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);

        $vacancy = JobVacancy::withCount('applications')
            ->findOrFail($id);

        return view('dashboard.management.careers.show', compact('vacancy'));
    }

    /**
     * Show the form for editing the specified vacancy.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);

        $vacancy = JobVacancy::findOrFail($id);

        return view('dashboard.management.careers.form', compact('vacancy'));
    }

    /**
     * Update the specified vacancy in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $vacancy = JobVacancy::findOrFail($id);
        $validated = $this->validateVacancy($request, $vacancy->id);

        DB::beginTransaction();
        try {
            // Handle flyer image upload
            $flyerPath = $vacancy->flyer_image;
            if ($request->hasFile('flyer_image')) {
                if ($vacancy->flyer_image) {
                    Storage::disk('public')->delete($vacancy->flyer_image);
                }
                $flyerPath = $request->file('flyer_image')->store('careers/flyers', 'public');
            }

            $vacancy->update([
                'title'            => $validated['title'],
                'slug'             => !empty($validated['slug']) ? $validated['slug'] : \Illuminate\Support\Str::slug($validated['title']),
                'department'       => $validated['department'],
                'location'         => $validated['location'],
                'type'             => $validated['type'],
                'experience'       => $validated['experience'] ?? null,
                'education'        => $validated['education'] ?? null,
                'salary_range'     => $validated['salary_range'] ?? null,
                'description'      => $validated['description'] ?? null,
                'responsibilities' => $this->parseJsonField($validated['responsibilities'] ?? null),
                'requirements'     => $this->parseJsonField($validated['requirements'] ?? null),
                'benefits'         => $this->parseJsonField($validated['benefits'] ?? null),
                'skills'           => $this->parseJsonField($validated['skills'] ?? null),
                'flyer_image'      => $flyerPath,
                'is_active'        => $request->boolean('is_active'),
                'is_featured'      => $request->boolean('is_featured'),
                'deadline'         => $validated['deadline'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('dashboard.careers.index')
                ->with('success', 'Lowongan kerja berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified vacancy from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $vacancy = JobVacancy::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($vacancy->flyer_image) {
                Storage::disk('public')->delete($vacancy->flyer_image);
            }

            // Delete associated application documents
            foreach ($vacancy->applications as $application) {
                if ($application->cv_path) Storage::disk('public')->delete($application->cv_path);
                if ($application->ktp_path) Storage::disk('public')->delete($application->ktp_path);
                if ($application->ijazah_path) Storage::disk('public')->delete($application->ijazah_path);
            }

            $vacancy->delete();

            DB::commit();

            return redirect()
                ->route('dashboard.careers.index')
                ->with('success', 'Lowongan kerja berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle vacancy status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $vacancy = JobVacancy::findOrFail($id);
        $vacancy->update(['is_active' => !$vacancy->is_active]);

        return response()->json([
            'success'   => true,
            'message'   => 'Status lowongan berhasil diperbarui.',
            'is_active' => $vacancy->is_active,
        ]);
    }

    /**
     * Validate vacancy request data.
     */
    protected function validateVacancy(Request $request, ?int $vacancyId = null): array
    {
        $slugRule = $vacancyId
            ? Rule::unique('job_vacancies', 'slug')->ignore($vacancyId)
            : 'unique:job_vacancies,slug';

        return $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'slug'             => ['nullable', 'string', 'max:250', $slugRule],
            'department'       => ['required', 'string', 'max:100'],
            'location'         => ['required', 'string', 'max:100'],
            'type'             => ['required', 'string', 'max:50'],
            'experience'       => ['nullable', 'string', 'max:100'],
            'education'        => ['nullable', 'string', 'max:100'],
            'salary_range'     => ['nullable', 'string', 'max:100'],
            'description'      => ['nullable', 'string'],
            'responsibilities' => ['nullable', 'string'],
            'requirements'     => ['nullable', 'string'],
            'benefits'         => ['nullable', 'string'],
            'skills'           => ['nullable', 'string'],
            'flyer_image'      => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active'        => ['boolean'],
            'is_featured'      => ['boolean'],
            'deadline'         => ['nullable', 'date'],
        ]);
    }

    /**
     * Parse JSON field from textarea input.
     */
    protected function parseJsonField(?string $value): ?array
    {
        if (empty($value)) {
            return null;
        }

        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        $lines = array_filter(array_map('trim', explode("\n", $value)));
        return !empty($lines) ? array_values($lines) : null;
    }
}
