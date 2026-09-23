<?php

namespace App\Http\Controllers;

use App\Constants\Permission as PermissionConstants;
use App\Models\User;
use App\Notifications\NewContactSubmissionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Submit contact form with anti-bot validation and content filtering
     */
    public function submit(Request $request)
    {
        // Anti-bot: Honeypot check
        if ($request->filled('website')) {
            // Bot detected (honeypot field should be empty)
            Log::warning('Contact form bot detected', ['ip' => $request->ip()]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid submission detected.'
            ], 422);
        }

        // Rate limiting: max 3 submissions per 10 minutes per IP
        $rateLimitKey = 'contact-submit:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'success' => false,
                'message' => "Terlalu banyak percobaan. Silakan coba lagi dalam " . ceil($seconds / 60) . " menit."
            ], 429);
        }

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|in:product,quote,service,partnership,other',
            'message' => 'required|string|max:5000',
        ]);

        // Content filtering
        $contentFilter = app(\App\Services\ContentFilterService::class);
        
        // Check name for inappropriate content
        if (!$contentFilter->isClean($validated['name'])) {
            return response()->json([
                'success' => false,
                'message' => 'Nama mengandung konten yang tidak pantas. Mohon gunakan nama yang sesuai.'
            ], 422);
        }

        // Check message for inappropriate content
        $messageCheckResult = $contentFilter->checkMessage($validated['message']);
        if (!$messageCheckResult['is_clean']) {
            return response()->json([
                'success' => false,
                'message' => 'Pesan Anda mengandung konten yang tidak pantas: ' . $messageCheckResult['reason'] . '. Mohon periksa kembali pesan Anda.'
            ], 422);
        }

        // Check company field if provided
        if (!empty($validated['company']) && !$contentFilter->isClean($validated['company'])) {
            return response()->json([
                'success' => false,
                'message' => 'Nama perusahaan mengandung konten yang tidak pantas.'
            ], 422);
        }

        // Increment rate limiter
        RateLimiter::hit($rateLimitKey, 600); // 10 minutes

        try {
            // Store submission in database
            $submission = \App\Models\ContactSubmission::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Push in-app notification for relevant dashboard users.
            $notificationRecipients = User::query()
                ->where('is_active', true)
                ->get()
                ->filter(function (User $user): bool {
                    if (!$user->notificationPreference('contact_submissions', true)) {
                        return false;
                    }

                    return $user->isAdmin() || $user->hasAnyPermission([
                        PermissionConstants::CONTACT_SUBMISSION_VIEW,
                        PermissionConstants::CONTACT_SUBMISSION_RESPOND,
                    ]);
                });

            if ($notificationRecipients->isNotEmpty()) {
                try {
                    Notification::send($notificationRecipients, new NewContactSubmissionNotification($submission));
                } catch (\Throwable $notificationError) {
                    Log::warning('Failed to dispatch in-app contact notification', [
                        'submission_id' => $submission->id,
                        'error' => $notificationError->getMessage(),
                    ]);
                }
            }

            // Send email notification to admin
            try {
                Mail::send('emails.contact-notification', [
                    'submission' => $submission
                ], function ($message) use ($validated) {
                    $message->to(config('mail.admin_email', 'admin@visiyosindo.com'))
                        ->subject('Pesan Baru dari Contact Form - ' . $validated['name']);
                    $message->replyTo($validated['email'], $validated['name']);
                });
            } catch (\Exception $e) {
                Log::error('Failed to send contact notification email', [
                    'error' => $e->getMessage(),
                    'submission_id' => $submission->id
                ]);
                // Continue even if email fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Pesan Anda telah berhasil dikirim. Tim kami akan segera menghubungi Anda.'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}
