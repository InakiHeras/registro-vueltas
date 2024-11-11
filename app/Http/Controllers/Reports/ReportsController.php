<?php

namespace App\Http\Controllers\Reports;

use App\Exports\VueltasExport;
use App\Http\Controllers\Controller;
use App\Models\TurnoAsistente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function index(){
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

        // Obtener todos los turnos de asistentes que tienen vueltas registradas
        $turnosAsistente = TurnoAsistente::has('vueltas') 
            ->with('vueltas') 
            ->paginate(10); 

        return Inertia::render('Units/VueltasReports', [
            'admin' => [
                'roles' => $user->roles,
                'permissions' => $permissions,
            ],
            'turnosAsistente' => $turnosAsistente
        ]);
    }

    public function exportTurnoAsistente($idTurnoAsistente)
    {
        $turnoAsistente = TurnoAsistente::findOrFail($idTurnoAsistente);
        $nombreAsistente = $turnoAsistente->usuario->name;

        return Excel::download(new VueltasExport($idTurnoAsistente, $nombreAsistente), "Reporte_Turno_Asistente_{$nombreAsistente}.xlsx");
    }
}
