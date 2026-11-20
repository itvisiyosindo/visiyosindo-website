<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'],
            'institution' => $validated['institution'] ?? null,
            'profession' => $validated['profession'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => User::ROLE_STUDENT,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard')->with('toast', [
            'type' => 'success',
            'message' => 'Pendaftaran akun berhasil! Selamat datang di Portal Pelajar.',
        ]);
    }
}
