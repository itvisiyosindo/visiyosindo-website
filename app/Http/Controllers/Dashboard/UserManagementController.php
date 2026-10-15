<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if (in_array($status, ['active', 'inactive'], true)) {
                $query->where('is_active', $status === 'active');
            }
        }

        $users = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
        ];

        return view('dashboard.rbac.user-management.index', [
            'users' => $users,
            'stats' => $stats,
            'filters' => [
                'search' => $request->input('search'),
                'status' => $request->input('status'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('dashboard.rbac.user-management.create', [
            'roles' => Role::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'is_active' => $request->boolean('is_active'),
            'role' => User::ROLE_CONTENT_CREATOR,
        ]);

        $selectedRoleIds = $validated['roles'] ?? [];
        $user->roles()->sync($selectedRoleIds);
        $this->syncLegacyRole($user, $selectedRoleIds);

        return redirect()->route('dashboard.rbac.user-management.index')
            ->with('success', "User '{$user->name}' berhasil dibuat.");
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('dashboard.rbac.user-management.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::where('is_active', true)->orderBy('name')->get(),
            'selectedRoles' => $user->roles()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        if ($user->id === $request->user()?->getAuthIdentifier() && !$request->boolean('is_active')) {
            return back()
                ->withInput()
                ->withErrors(['is_active' => 'Akun Anda sendiri tidak bisa dinonaktifkan.']);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $selectedRoleIds = $validated['roles'] ?? [];
        $user->roles()->sync($selectedRoleIds);
        $this->syncLegacyRole($user, $selectedRoleIds);

        return redirect()->route('dashboard.rbac.user-management.index')
            ->with('success', "User '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Update user password.
     */
    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => $validated['password'],
        ]);

        return redirect()->route('dashboard.rbac.user-management.edit', $user)
            ->with('success', "Password untuk '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified user.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()?->getAuthIdentifier()) {
            return back()->withErrors(['delete' => 'Akun Anda sendiri tidak bisa dihapus.']);
        }

        if ($this->isLastAdmin($user)) {
            return back()->withErrors(['delete' => 'Tidak bisa menghapus admin terakhir pada sistem.']);
        }

        $userName = $user->name;
        $user->roles()->detach();
        $user->directPermissions()->detach();
        $user->delete();

        return redirect()->route('dashboard.rbac.user-management.index')
            ->with('success', "User '{$userName}' berhasil dihapus.");
    }

    /**
     * Sync RBAC role to legacy enum role for backward compatibility.
     */
    private function syncLegacyRole(User $user, array $selectedRoleIds): void
    {
        $legacyMap = [
            'admin' => User::ROLE_ADMIN,
            'director' => User::ROLE_DIRECTOR,
            'content-creator' => User::ROLE_CONTENT_CREATOR,
            'marketing-manager' => User::ROLE_DIGITAL_MARKETING,
            'hr-manager' => User::ROLE_HR,
        ];

        if (empty($selectedRoleIds)) {
            return;
        }

        $priority = ['admin', 'director', 'hr-manager', 'marketing-manager', 'content-creator'];
        $selectedSlugs = Role::whereIn('id', $selectedRoleIds)->pluck('slug')->all();

        $roleSlug = null;
        foreach ($priority as $slug) {
            if (in_array($slug, $selectedSlugs, true)) {
                $roleSlug = $slug;
                break;
            }
        }

        if ($roleSlug && isset($legacyMap[$roleSlug])) {
            $user->update(['role' => $legacyMap[$roleSlug]]);
        }
    }

    /**
     * Determine if target user is the last admin.
     */
    private function isLastAdmin(User $user): bool
    {
        $isAdminUser = $user->roles()->where('slug', 'admin')->exists() || $user->role === User::ROLE_ADMIN;

        if (!$isAdminUser) {
            return false;
        }

        $otherAdmins = User::query()
            ->where('id', '!=', $user->id)
            ->where(function ($query) {
                $query->where('role', User::ROLE_ADMIN)
                    ->orWhereHas('roles', fn ($subQuery) => $subQuery->where('slug', 'admin'));
            })
            ->count();

        return $otherAdmins === 0;
    }
}
