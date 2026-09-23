<?php

namespace App\Notifications;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactSubmissionNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly ContactSubmission $submission)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'contact_submission',
            'title' => 'Pesan Baru dari Contact Form',
            'message' => $this->submission->name . ' (' . $this->submission->email . ') mengirim pesan baru.',
            'url' => route('dashboard.contact-submissions.show', $this->submission),
            'icon' => 'mail',
            'subject' => $this->submission->subject_label,
            'submission_id' => $this->submission->id,
        ];
    }
}
