<?php

namespace App\Http\Controllers;

use App\Models\StudentCertificate;
use Illuminate\View\View;

class PublicCertificateController extends Controller
{
    /**
     * Verify certificate publicly by code.
     */
    public function verify(string $code): View
    {
        $certificate = StudentCertificate::with(['user', 'trainingClass'])
            ->where('verification_code', $code)
            ->first();

        return view('pages.verify-certificate', compact('certificate', 'code'));
    }
}
