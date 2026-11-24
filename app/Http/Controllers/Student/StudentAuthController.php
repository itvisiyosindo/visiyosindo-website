<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class StudentAuthController extends Controller
{
    /**
     * Show the student registration form.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            if (Auth::user()->isStudent()) {
                return redirect()->route('student.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return view('auth.student-register');
    }

    /**
     * Handle registration for students.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:25'],
            'institution' => ['nullable', 'string', 'max:150'],
            'profession' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi untuk pencetakan sertifikat.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan login.',
            'phone.required' => 'Nomor WhatsApp wajib diisi untuk koordinasi pelatihan.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'institution' => $validated['institution'] ?? null,
            'profession' => $validated['profession'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => User::ROLE_STUDENT,
            'is_active' => true,
        ];

        // Ensure student role exists in RBAC table
        try {
            $studentRole = Role::firstOrCreate(
                ['slug' => 'student'],
                [
                    'name' => 'Member Visi Academy',
                    'description' => 'Akses portal member Visi Academy, program pelatihan & webinar, materi, dan sertifikat',
                    'is_active' => true,
                ]
            );
        } catch (\Throwable $e) {
            $studentRole = null;
        }

        // Create user with auto-recovery if MySQL enum rejects 'student'
        try {
            $user = User::create($userData);
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'Data truncated') || str_contains($e->getMessage(), '1265')) {
                // Try altering column on the fly
                try {
                    DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(50) NOT NULL DEFAULT 'student'");
                    $user = User::create($userData);
                } catch (\Throwable $alterErr) {
                    // Fallback to legacy enum value 'content_creator', and assign 'student' via RBAC table
                    $userData['role'] = 'content_creator';
                    $user = User::create($userData);
                }
            } else {
                throw $e;
            }
        }

        if ($studentRole && !$user->roles()->where('id', $studentRole->id)->exists()) {
            $user->roles()->attach($studentRole);
        }

        Auth::login($user);

        return redirect()->route('student.dashboard')->with('toast', [
            'type' => 'success',
            'message' => 'Pendaftaran akun berhasil! Selamat datang di Portal Member Visi Academy.',
        ]);
    }
}
