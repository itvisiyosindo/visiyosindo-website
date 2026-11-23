<?php

namespace App\Http\Controllers;

use App\Models\StudentCertificate;
use App\Support\AcademySchemaEnsurer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicCertificateController extends Controller
{
    /**
     * Verify certificate publicly by code.
     */
    public function verify(string $code): View
    {
        AcademySchemaEnsurer::ensure();

        $certificate = StudentCertificate::with(['user', 'trainingClass'])
            ->where('verification_code', $code)
            ->first();

        return view('pages.verify-certificate', compact('certificate', 'code'));
    }

    /**
     * Stream or download the official certificate PDF publicly by verification code.
     */
    public function file(Request $request, string $code): BinaryFileResponse
    {
        AcademySchemaEnsurer::ensure();

        $certificate = StudentCertificate::where('verification_code', $code)->firstOrFail();

        if (!$certificate->pdf_path) {
            abort(404, 'File sertifikat PDF belum tersedia.');
        }

        $fullPath = null;
        if (Storage::disk('local')->exists($certificate->pdf_path)) {
            $fullPath = Storage::disk('local')->path($certificate->pdf_path);
        } elseif (Storage::disk('public')->exists($certificate->pdf_path)) {
            $fullPath = Storage::disk('public')->path($certificate->pdf_path);
        }

        if (!$fullPath) {
            abort(404, 'File sertifikat PDF tidak ditemukan.');
        }

        $filename = $certificate->original_filename ?: ('Sertifikat-' . Str::slug($certificate->certificate_number) . '.pdf');
        $disposition = $request->boolean('download') ? 'attachment' : 'inline';

        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
        ]);
    }
}
