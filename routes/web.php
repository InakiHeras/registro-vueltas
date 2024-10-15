<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Unidades\UnidadesQRController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [
    DashboardController::class, 'index'
])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['role_or_permission:EDIT_PROFILE_VIEW|admin'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware(['role_or_permission:EDIT_PROFILE_UPDATE|admin'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->middleware(['role_or_permission:EDIT_PROFILE_DESTROY|admin'])->name('profile.destroy');
    // Unidades
    Route::get('/units', [UnidadesQRController::class, 'index'])->middleware(['role_or_permission:VIEW_UNITS_CODES|admin'])->name('units.view');
    Route::post('/units', [UnidadesQRController::class, 'storeUnit'])->middleware(['role_or_permission:EDIT_UNITS_CODES|admin'])->name('units.store');

    // Rutas de administrador
    Route::middleware('role:admin')->prefix('admin')->group(function() {
        Route::get('/users', [AdminController::class, 'getUsers'])->name('list.users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}', [AdminController::class, 'editUser'])->name('users.update');
        Route::get('/users/{user}/roles', [AdminController::class, 'getUserRoles'])->name('users.roles');
        Route::post('/users/{user}/roles', [AdminController::class, 'updateUserRole'])->name('users.updateRole');
        Route::get('/permissions', [AdminController::class, 'getPermissions'])->name('permission.view');
        Route::post('/permission', [AdminController::class, 'storePermission'])->name('store.permission');
        Route::get('/roles', [AdminController::class, 'getRoles'])->name('roles.view');
        Route::post('/roles', [AdminController::class, 'storeRole'])->name('roles.store');
        Route::get('/role/{id_role}', [AdminController::class, 'getRolePermissions'])->name('get.permissions.role');
        Route::post('/role/accion', [AdminController::class, 'updateRolePermission'])->name('role.permission.update');
    });
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
