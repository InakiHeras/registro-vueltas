<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dotacion;
use App\Models\TurnoAsistente;
use App\Models\TurnoOperador;
use App\Models\Vuelta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class TurnosController extends Controller
{
    public function verficarTurnoAbierto(Request $request)
    {
        $token = $request->bearerToken();
        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken->tokenable;

        // Buscar si el usuario tiene un turno abierto
        $turnoAbierto = TurnoAsistente::where('ClaveAsistente', $user->id)
                                        ->where('Estatus', true)
                                        ->first();

        if ($turnoAbierto) {
            return response()->json([
                'turno_abierto' => true,
                'turno' => $turnoAbierto
            ], 200);
        }

        return response()->json(['turno_abierto' => false], 200);                                
    }
    
    public function abrirTurno(Request $request)
    {
        $token = $request->bearerToken();
        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken->tokenable;

        // Verificar si el usuario ya tiene un turno abierto
        $turnoAbierto = TurnoAsistente::where('ClaveAsistente', $user->id)
                                      ->where('Estatus', true)
                                      ->first();

        if ($turnoAbierto) {
            return response()->json(['error' => 'Ya tienes un turno abierto'], 403);
        }

        $turno = TurnoAsistente::create([
            'ClaveAsistente' => $user->id,
            'Nombre' => $user->name,
            'Zona' => $request->zona,
            'IdUsuario' => $user->id,
            'FechaInicio' => now(),
            'Estatus' => true,
            'CreatedBy' => $user->name,
        ]);

        return response()->json([
            'message' => 'Turno abierto correctamente', 
            'turno' => $turno], 
            200
        );
    }

    public function cerrarTurno(Request $request)
    {
        $token = $request->bearerToken();
        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken->tokenable;

        $turno = TurnoAsistente::where('ClaveAsistente', Auth::id())
                    ->where('Estatus', true)
                    ->first();

        if (!$turno) {
            return response()->json(['error' => 'No se encontró el turno o ya está cerrado'], 404);
        }

        $turno->update([
            'FechaFinalizado' => now(),
            'Estatus' => false, // Turno cerrado
            'UpdatedBy' => Auth::user()->name,
        ]);

        return response()->json([
            'message' => 'Turno cerrado correctamente', 
            'turno' => $turno], 
            200
        );
    }

    // Turno del operador

    public function verificarTurnoOperador(Request $request)
    {
        $operador = (int)$request->ClaveOperador;
        // Verificar si el operador ya tiene un turno activo
        $turnoAbierto = TurnoOperador::where('ClaveOperador', $operador)
                              ->where('Estatus', true)
                              ->first();

        if ($turnoAbierto) {
            return response()->json([
                'turno_abierto' => true,
                'turno' => $turnoAbierto
            ], 200);
        }

        return response()->json(['turno_abierto' => false], 200); 
    }

    public function abrirTurnoOperador(Request $request)
    {
        $operador = (int)$request->ClaveOperador;
        // Verificar si el operador ya tiene un turno activo
        $turnoAbierto = TurnoOperador::where('ClaveOperador', $request)
                              ->where('Estatus', true)
                              ->first();

        if ($turnoAbierto) {
            return response()->json(['error' => 'Ya tienes un turno abierto'], 403);
        }

        $turno = TurnoOperador::create([
            'ClaveOperador' => $operador,
            'Operador' => $request->Operador,
            'Turno' => $request->Turno,
            'Ruta' => $request->Ruta,
            'Zona' => $request->Zona,
            'FechaInicio' => now(),
            'Estatus' => true,
            'CreatedBy' => Auth::user()->name,
        ]);

        return response()->json([
            'message' => 'Turno abierto correctamente', 
            'turno' => $turno], 
            200
        );
    }

    public function cerrarTurnoOperador(Request $request)
    {
        $operador = (int)$request->ClaveOperador;
        $turnoOperador = $request->TurnoOperador;

        // Verificar si hay alguna vuelta en curso
        $vueltaEnCurso = Vuelta::where('IdTurnoOperador', $turnoOperador)
                            ->where('Estado', 'En curso')
                            ->exists();

        if ($vueltaEnCurso) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede cerrar el turno. Hay una vuelta en curso.',
            ], 400);
        }

        // Buscar el turno activo del operador
        $turno = TurnoOperador::where('ClaveOperador', $operador)
                            ->where('Estatus', true)
                            ->first();

        if (!$turno) {
            return response()->json(['error' => 'No se encontró el turno o ya está cerrado'], 404);
        }

        // Actualizar el estado del turno a cerrado
        $turno->update([
            'FechaFinalizado' => now(),
            'Estatus' => false, // Turno cerrado
            'UpdatedBy' => Auth::user()->name,
        ]);

        return response()->json([
            'message' => 'Turno cerrado correctamente', 
            'turno' => $turno
        ], 200);
    }
}
