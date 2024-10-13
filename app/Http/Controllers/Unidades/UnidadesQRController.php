<?php

namespace App\Http\Controllers\Unidades;

use App\Http\Controllers\Controller;
use App\Models\UnidadesCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UnidadesQRController extends Controller
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

        $units = UnidadesCode::orderBy('CreatedAt', 'desc')->paginate(10);

        return Inertia::render('Units/Units', [
            'admin' => [
                'roles' => $user->roles,
                'permissions' => $permissions,
            ],
            'units' => $units,
        ]);
    }

    public function storeUnit(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'Unidad' => 'required|integer',
            'qrImage' => 'required', // Validar la imagen
        ]);
    
        $unidad = $request->Unidad;
        $qrImageData = $request->qrImage;
    
        list($type, $qrImageData) = explode(';', $qrImageData);
        list(, $qrImageData)      = explode(',', $qrImageData);
        $qrImageData = base64_decode($qrImageData);

        $fileName = 'qrcodes/' . $unidad . '.png';
        Storage::disk('public')->put($fileName, $qrImageData);
    
        UnidadesCode::create([
            'Unidad' => $unidad,
            'CodeQ' => $fileName,
            'CreatedAt' => now(),
            'CreatedBy' => $user->name,
        ]);
    
        return redirect()->back()->with('success', 'Unidad guardada correctamente');
    }
}
