<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserRoleController extends Controller
{
    /**
     * Display a listing of users for role assignment.
     */
    public function index(): View
    {
        $users = User::with('roles')->paginate(15);
        $roles = Role::all();

        return view('dashboard.rbac.users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for editing user roles.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        $userRoles = $user->roles()->pluck('id')->toArray();

        return view('dashboard.rbac.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    /**
     * Update user roles.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('dashboard.rbac.users.index')
            ->with('success', "Roles untuk '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Assign role to user (direct method).
     */
    public function assignRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::find($validated['role_id']);
        $user->assignRole($role);

        return back()->with('success', "Role '{$role->name}' berhasil diberikan kepada '{$user->name}'!");
    }

    /**
     * Remove role from user.
     */
    public function removeRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $role = Role::find($validated['role_id']);
        $user->removeRole($role);

        return back()->with('success', "Role '{$role->name}' berhasil dihapus dari '{$user->name}'!");
    }
}
