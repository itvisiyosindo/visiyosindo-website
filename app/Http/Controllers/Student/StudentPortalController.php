<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentCertificate;
use App\Models\TrainingClass;
use App\Models\TrainingEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentPortalController extends Controller
{
    /**
     * Display student portal dashboard (Overview, My Classes, Certificates, Profile).
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $enrollments = $user->enrollments()
            ->with(['trainingClass', 'certificate'])
            ->latest()
            ->get();

        $certificates = $user->studentCertificates()
            ->with('trainingClass')
            ->latest()
            ->get();

        // Visilab WhatsApp for manual confirmation
        $adminWhatsApp = '6281261457547';

        return view('student.dashboard', compact('user', 'enrollments', 'certificates', 'adminWhatsApp'));
    }

    /**
     * Display catalogue of available training classes.
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
            return redirect()->route('student.dashboard')->with('toast', [
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

        return redirect()->route('student.dashboard')->with('toast', [
            'type' => 'success',
            'message' => 'Berhasil mendaftar kelas! Silakan lakukan konfirmasi pembayaran via WhatsApp.',
        ]);
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

        return redirect()->route('student.dashboard')->with('toast', [
            'type' => 'success',
            'message' => 'Data diri berhasil diperbarui!',
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
}
