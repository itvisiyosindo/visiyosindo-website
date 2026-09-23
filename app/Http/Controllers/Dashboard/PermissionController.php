<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index(): View
    {
        $permissions = Permission::orderBy('category')
            ->orderBy('name')
            ->paginate(30);
        
        $categories = Permission::distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('dashboard.rbac.permissions.index', [
            'permissions' => $permissions,
            'categories' => $categories,
        ]);
    }
}
