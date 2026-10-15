<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        // Rate limiting - Per IP and per email
        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();
        $ipThrottleKey = 'login-ip:' . $request->ip();
        
        // Check IP-based rate limiting (more strict)
        if (RateLimiter::tooManyAttempts($ipThrottleKey, 10)) {
            $seconds = RateLimiter::availableIn($ipThrottleKey);
            
            return response()->json([
                'success' => false,
                'message' => "Too many login attempts from your network. Please try again in {$seconds} seconds.",
            ], 429);
        }
        
        // Check email-based rate limiting
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            return response()->json([
                'success' => false,
                'message' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ], 429);
        }

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        // SECURITY: Don't reveal if user exists or not - use generic message
        if (!$user) {
            RateLimiter::hit($throttleKey, 300); // 5 minutes decay
            RateLimiter::hit($ipThrottleKey, 600); // 10 minutes decay
            
            // Log failed attempt for security monitoring
            Log::warning('Failed login attempt - User not found', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password. Please check your credentials and try again.',
            ], 401);
        }

        // Check if user is active
        if (!$user->is_active) {
            // Log deactivated account attempt
            Log::warning('Login attempt on deactivated account', [
                'email' => $request->email,
                'user_id' => $user->id,
                'ip' => $request->ip(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Your account has been deactivated. Please contact administrator.',
            ], 403);
        }

        // Attempt login
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 300); // 5 minutes decay
            RateLimiter::hit($ipThrottleKey, 600); // 10 minutes decay
            
            // Log failed login attempt
            Log::warning('Failed login attempt - Invalid password', [
                'email' => $request->email,
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password. Please check your credentials and try again.',
            ], 401);
        }

        // Clear rate limiters on successful login
        RateLimiter::clear($throttleKey);
        RateLimiter::clear($ipThrottleKey);

        // Regenerate session for security
        $request->session()->regenerate();

        // Log successful login
        Log::info('Successful login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Welcome back, {$user->name}!",
            'redirect' => route('dashboard'),
            'user' => [
                'name' => $user->name,
                'role' => $user->role_name,
            ],
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'You have been logged out successfully.',
                'redirect' => route('login'),
            ]);
        }

        return redirect()->route('login')->with('toast', [
            'type' => 'success',
            'message' => 'You have been logged out successfully.',
        ]);
    }
}
