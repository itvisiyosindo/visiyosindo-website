<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\CertificateCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    /**
     * Display a listing of certificates.
     */
    public function index(Request $request): View
    {
        $query = Certificate::query()
            ->with('category');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('cert_number', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categoryId = $request->get('category')) {
            $query->where('certificate_category_id', $categoryId);
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $certificates = $query->ordered()
            ->paginate(12)
            ->withQueryString();

        $categories = CertificateCategory::active()->ordered()->get();

        return view('dashboard.management.certificates.index', compact('certificates', 'categories'));
    }

    /**
     * Show the form for creating a new certificate.
     */
    public function create(): View
    {
        $categories = CertificateCategory::active()->ordered()->get();
        return view('dashboard.management.certificates.form', compact('categories'));
    }

    /**
     * Store a newly created certificate in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'certificate_category_id' => ['required', 'exists:certificate_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'cert_number' => ['nullable', 'string', 'max:100'],
            'issued_date' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'in:active,expired,pending'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('certificates', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'active';

        Certificate::create($validated);

        return redirect()->route('dashboard.certificates.index')
            ->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified certificate.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $certificate = Certificate::findOrFail($id);
        $categories = CertificateCategory::active()->ordered()->get();
        return view('dashboard.management.certificates.form', compact('certificate', 'categories'));
    }

    /**
     * Update the specified certificate in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $certificate = Certificate::findOrFail($id);

        $validated = $request->validate([
            'certificate_category_id' => ['required', 'exists:certificate_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'issuer' => ['nullable', 'string', 'max:255'],
            'cert_number' => ['nullable', 'string', 'max:100'],
            'issued_date' => ['nullable', 'date'],
            'valid_until' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'in:active,expired,pending'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
                Storage::disk('public')->delete($certificate->image);
            }

            $image = $request->file('image');
            $imagePath = $image->store('certificates', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['status'] = $validated['status'] ?? 'active';

        $certificate->update($validated);

        return redirect()->route('dashboard.certificates.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    /**
     * Remove the specified certificate from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $certificate = Certificate::findOrFail($id);

        // Delete image
        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            Storage::disk('public')->delete($certificate->image);
        }

        $certificate->delete();

        return redirect()->route('dashboard.certificates.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
