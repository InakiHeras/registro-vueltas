<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\json;

class AdminController extends Controller
{
    public function getUsers(){

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

        $users = User::latest()->paginate(10);

        return Inertia::render('Admin/Users', [
            'admin' => [
                'roles' => $user->roles,
                'permissions' => $permissions,
            ],
            'users' => $users
        ]);
    }

    public function storeUser(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);
        
        $fields['password'] = Hash::make($fields['password']);

        User::create($fields);

        return redirect()->back()->with('success', 'Usuario creado correctamente');
    }

    public function editUser(Request $request, $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
    
        // Si hay un nuevo password, lo encriptamos
        if ($fields['password']) {
            $fields['password'] = Hash::make($fields['password']);
        } else {
            unset($fields['password']); // No actualiza el password si está vacío
        }
    
        // Actualizamos el usuario
        $user = User::findOrFail($id);
        $user->update($fields);
    
        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
    }

    public function getUserRoles(User $user)
    {
        $rolesAll = Role::all();
        $userRoles = $user->roles;

        return response()->json([
            'rolesAll' => $rolesAll,
            'userRoles' => $userRoles,
        ]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        $roleName = $request->input('role');
        $action = $request->input('action');

        if ($action == 'ADD') {
            $user->assignRole($roleName);
        } elseif ($action == 'CLEAN') {
            $user->removeRole($roleName);
        }

        $rolesAll = Role::all();
        $userRoles = $user->roles;

        return response()->json([
            'rolesAll' => $rolesAll,
            'userRoles' => $userRoles,
        ]);
    }

    public function getPermissions()
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

        $allPermissions = Permission::latest()->paginate(10);
        $permissionsNotInDB = $this->getPermissionsNotInDB();

        return Inertia::render('Admin/Permissions', [
            'admin' => [
                'roles' => $user->roles,
                'permissions' => $permissions,
            ],
            'permissions' => [
                'allPermissions' => $allPermissions,
                'permissionsNotInDB' => $permissionsNotInDB,] 
        ]);
    }

    public function storePermission(Request $request)
    {
        $validatedData = $request->validate([
            'code' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value == '') {
                        $fail('El campo ' . $attribute . ' Es obligatorio');
                    }
                }
            ],
            // Añadir más campos según sea necesario
        ]);

        Permission::create(['name' => $request->code]);

        return Redirect::route('permission.view');
    }

    private function getPermissionsNotInDB()
    {
        $routes = Route::getRoutes();
        $permissionDB = Permission::pluck('name')->toArray();
        $permissions = [];

        foreach ($routes as $route) {
            $middlewares = $route->gatherMiddleware();

            foreach ($middlewares as $middleware) {
                if (strpos($middleware, 'role_or_permission:') !== false) {
                    // Extraer el permiso del middleware
                    $permissionString = str_replace('role_or_permission:', '', $middleware);

                    // Los permisos pueden estar separados por '|', así que los dividimos
                    $routePermissions = explode('|', $permissionString);

                    if (!in_array($routePermissions[0], $permissionDB)) {
                        $permissions[] = [
                            'permiso' => $routePermissions[0],
                            'url' => $route->uri(),
                            'method' => $route->methods()[0], // Se asume que la ruta usa un solo método HTTP
                        ];
                    }
                }
            }
        }

        return $permissions;
    }

    public function getRoles()
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

        $roles = Role::latest()->paginate(10);

        return Inertia::render('Admin/Roles', [
            'admin' => [
                'roles' => $user->roles,
                'permissions' => $permissions
            ],
            'roles' => $roles,
        ]);
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'rolename' => [
                'required',
                function($attribute, $value, $fail) {
                    if ($value == '') {
                        $fail('El campo ' . $attribute . ' Es obligatorio');
                    }

                    $rol = Role::where('name', $value)->first();

                    if (!empty($rol)) {
                        $fail('El nombre del rol ya existe.');
                    }
                }
            ]
        ]);

        Role::create(['name' => $request->rolename]);

        return redirect()->route('roles.view');
    }

    public function getRolePermissions($id_role)
    {
        $rol = Role::findById($id_role);

        $rolePermissions = $rol->permissions;
        $arrayName = $rolePermissions->pluck('name')->toArray();
        $permissions = Permission::whereNotIn('name', $arrayName)->get();

        return response()->json(
            [
                'permissions_all' => $permissions,
                'permissions_role' => $rolePermissions,
            ]
        );
    }

    public function updateRolePermission(Request $request)
    {
        $request->validate([
            'Accion' => [
                'required',
                'string',
                function($attribute, $value, $fail) {
                    if ($value !== 'ADD' && $value !== 'CLEAN') {
                        $fail('El campo acción debe ser ADD o CLEAN');
                    }
                }
            ],
            'PermissionName' => [
                'required',
                function($attribute, $value, $fail) {
                    $rolExist = Permission::where('name', $value);
                    if (!$rolExist) {
                        $fail('No existe el rol a asignar');
                    }
                }
            ],
            'RolId' => [
                'Required',
            ],
        ]);

        $rol = Role::find($request->RolId);

        if ($request->Accion == 'ADD') {
            $rol->givePermissionTo($request->PermissionName);
            return response()->json(['Permiso agregado correctamente']);
        }

        if ($request->Accion == 'CLEAN') {
            $rol->revokePermissionTo($request->PermissionName);
            return response()->json(['Permiso removido correctamente.']);
        }

        return response()->json(['Algo desconocido.']);
    }
}
