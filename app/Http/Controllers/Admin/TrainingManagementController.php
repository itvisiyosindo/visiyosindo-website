<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentCertificate;
use App\Models\TrainingEnrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TrainingManagementController extends Controller
{
    /**
     * Display a listing of training enrollments.
     */
    public function index(Request $request): View
    {
        $query = TrainingEnrollment::with(['user', 'trainingClass', 'certificate'])
            ->latest();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
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

        return view('dashboard.management.trainings.index', compact('enrollments', 'stats'));
    }

    /**
     * Approve student enrollment (payment confirmed via WA).
     */
    public function approve(int $id): RedirectResponse
    {
        $enrollment = TrainingEnrollment::findOrFail($id);
        $enrollment->update([
            'status' => TrainingEnrollment::STATUS_ACTIVE,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Status pendaftaran berhasil disetujui (Aktif).',
        ]);
    }

    /**
     * Mark training completed and issue certificate.
     */
    public function complete(int $id): RedirectResponse
    {
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
            'message' => 'Peserta berhasil diluluskan dan sertifikat telah diterbitkan!',
        ]);
    }
}
