<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Show profile management page.
     */
    public function profile(Request $request): View
    {
        return view('dashboard.account.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profile data.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $payload['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($payload);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ], [
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    /**
     * Show account settings page.
     */
    public function settings(Request $request): View
    {
        $settings = $this->resolveSettings((array) ($request->user()->preferences ?? []));

        return view('dashboard.account.settings', compact('settings'));
    }

    /**
     * Update account settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'default_analytics_period' => ['required', 'in:7,30,60,90'],
        ]);

        $user = $request->user();
        $preferences = (array) ($user->preferences ?? []);

        $preferences['notifications'] = [
            'contact_submissions' => $request->boolean('notify_contact_submissions'),
            'job_applications' => $request->boolean('notify_job_applications'),
            'system_updates' => $request->boolean('notify_system_updates'),
        ];

        $preferences['dashboard'] = [
            'default_analytics_period' => (int) $validated['default_analytics_period'],
        ];

        $user->update([
            'preferences' => $preferences,
        ]);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    /**
     * Resolve user settings with sane defaults.
     *
     * @return array<string, mixed>
     */
    private function resolveSettings(array $preferences): array
    {
        return [
            'notify_contact_submissions' => (bool) data_get($preferences, 'notifications.contact_submissions', true),
            'notify_job_applications' => (bool) data_get($preferences, 'notifications.job_applications', true),
            'notify_system_updates' => (bool) data_get($preferences, 'notifications.system_updates', true),
            'default_analytics_period' => (int) data_get($preferences, 'dashboard.default_analytics_period', 30),
        ];
    }
}
