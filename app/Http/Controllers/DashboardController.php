<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $directPermissions = DB::table('model_has_permissions')
            ->join('permissions', 'model_has_permissions.permission_id', '=', 'permissions.id')
            ->where('model_has_permissions.model_id', $user->id)
            ->where('model_has_permissions.model_type', User::class)
            ->select('permissions.name')
            ->pluck('name');

        $rolePermissions = DB::table('model_has_roles')
            ->join('role_has_permissions', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('model_has_roles.model_type', User::class)
            ->select('permissions.name')
            ->pluck('name');

        $permissions = $directPermissions->merge($rolePermissions)->unique();

        return Inertia::render(
            'Dashboard', 
            [
                'admin' => [
                    'roles' => $user->roles,
                    'permissions' => $permissions,
                ],
            ]
        );
    }
}
