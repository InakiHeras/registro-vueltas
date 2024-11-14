<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TurnoAsistente;
use App\Models\Vuelta;
use App\Models\VueltaPerdida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class VueltasController extends Controller
{
    public function registrarVuelta(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'id_vuelta_perdida' => 'nullable|integer',
            'kilometraje_inicial' => 'nullable|integer',
            'hora_salida' => 'required|date_format:Y-m-d H:i:s',
            'kilometraje_final' => 'nullable|integer',
            'hora_llegada' => 'nullable|date_format:Y-m-d H:i:s',
            'boletos_vendidos' => 'nullable|integer',
            'id_turno_operador' => 'required|integer',
            'estado' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $token = $request->bearerToken();
        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken->tokenable;

        $turno = TurnoAsistente::where('ClaveAsistente', $user->id)
                                      ->where('Estatus', true)
                                      ->first();

        // Verificar si ya hay una vuelta en curso para el operador
        $vueltaEnCurso = Vuelta::where('IdTurnoOperador', $request->id_turno_operador)
                            ->where('Estado', 'En curso')
                            ->first();
        
        if ($vueltaEnCurso) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede registrar una nueva vuelta mientras hay una en curso.',
            ], 400);
        }

        $vuelta = Vuelta::create([
            'id_vuelta_perdida' => $request->id_vuelta_perdida,
            'KilometrajeInicial' => $request->kilometraje_inicial,
            'HoraSalida' => $request->hora_salida,
            'KilometrajeFinal' => $request->kilometraje_final,
            'HoraLlegada' => $request->hora_llegada,
            'BoletosVendidos' => $request->boletos_vendidos,
            'IdTurnoOperador' => $request->id_turno_operador,
            'IdTurnoAsistente' => $turno->IdTurnoAsistente,
            'Estado' => $request->estado,
        ]);

        return response()->json([
            'success' => true,
            'vuelta' => $vuelta,
        ], 201);
    }

    public function actualizarVuelta(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kilometraje_final' => 'nullable|integer',
            'hora_llegada' => 'nullable|date_format:Y-m-d H:i:s',
            'boletos_vendidos' => 'nullable|integer',
            'motivo_perdida' => 'nullable|integer',
            'estado' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        // Encontrar la vuelta por su ID
        $vuelta = Vuelta::find($id);

        if (!$vuelta) {
            return response()->json([
                'success' => false,
                'message' => 'Vuelta no encontrada',
            ], 404);
        }

        // Actualizar solo los campos que tengan un valor no nulo en el request
        if (!is_null($request->kilometraje_final)) {
            $vuelta->KilometrajeFinal = $request->kilometraje_final;
        }
        if (!is_null($request->hora_llegada)) {
            $vuelta->HoraLlegada = $request->hora_llegada;
        }
        if (!is_null($request->boletos_vendidos)) {
            $vuelta->BoletosVendidos = $request->boletos_vendidos;
        }
        if (!is_null($request->motivo_perdida)) {
            $vuelta->id_vuelta_perdida = $request->motivo_perdida;
        }
        $vuelta->Estado = $request->estado; // Cambiar estado, siempre se actualiza
        $vuelta->save();

        return response()->json([
            'success' => true,
            'vuelta' => $vuelta,
        ], 200);
    }

    public function listarVueltas($idTurnoOperador)
    {
        $vueltas = Vuelta::where('IdTurnoOperador', $idTurnoOperador)->get();

        if ($vueltas->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron vueltas para este operador',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'vueltas' => $vueltas,
        ], 200);
    }

    public function obtenerUltimoIdVuelta($idTurnoOperador)
    {
        $ultimaVuelta = Vuelta::where('IdTurnoOperador', $idTurnoOperador)
            ->orderBy('created_at', 'desc') 
            ->first();

        if ($ultimaVuelta) {
            return response()->json([
                'success' => true,
                'idVuelta' => $ultimaVuelta->IdVuelta,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ninguna vuelta para este turno de operador.',
            ], 404);
        }
    }

    public function obtenerVueltasEnCurso($idTurnoOperador)
    {
        $vueltasEnCurso = Vuelta::where('IdTurnoOperador', $idTurnoOperador)
                                ->where('Estado', 'En curso')
                                ->get();

        return response()->json(['vueltas' => $vueltasEnCurso], 200);
    }

    public function listarMotivosPerdida()
    {
        $motivos = VueltaPerdida::select('id', 'clave', 'motivo')->get();
        
        return response()->json([
            'success' => true,
            'motivos' => $motivos,
        ], 200);
    }

    public function obtenerMotivoPerdida($id)
    {
        $motivo = VueltaPerdida::find($id);

        if ($motivo) {
            return response()->json(['success' => true, 'motivo' => $motivo], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Motivo no encontrado'], 404);
        }
    }
}
