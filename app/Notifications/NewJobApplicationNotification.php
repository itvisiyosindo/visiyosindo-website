<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewJobApplicationNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly JobApplication $application)
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
        $application = $this->application->loadMissing('vacancy');
        $vacancy = $application->vacancy;

        $url = route('dashboard.careers.index');

        if ($vacancy) {
            $url = route('dashboard.careers.applicants.show', [
                $vacancy->encrypted_id,
                $application->encrypted_id,
            ]);
        }

        return [
            'type' => 'job_application',
            'title' => 'Lamaran Kerja Baru Masuk',
            'message' => $application->full_name . ' melamar posisi ' . ($vacancy?->title ?? 'unknown') . '.',
            'url' => $url,
            'icon' => 'briefcase',
            'application_id' => $application->id,
            'vacancy_id' => $vacancy?->id,
        ];
    }
}
