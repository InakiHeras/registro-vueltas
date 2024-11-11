<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TurnosController;
use App\Http\Controllers\API\VueltasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login_app', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/turno/abrir', [TurnosController::class, 'abrirTurno']);
    Route::post('/turno/cerrar', [TurnosController::class, 'cerrarTurno']);
    Route::get('/turno/verificar', [TurnosController::class, 'verficarTurnoAbierto']);
    Route::post('/operador/abrir', [TurnosController::class, 'abrirTurnoOperador']);
    Route::post('/operador/cerrar', [TurnosController::class, 'cerrarTurnoOperador']);
    Route::post('/operador/verificar', [TurnosController::class, 'verificarTurnoOperador']);
    Route::post('/turnosoperadores/obtener', [TurnosController::class, 'obtenerTurnoOperador']);
    Route::post('/vueltas/registrar', [VueltasController::class, 'registrarVuelta']);
    Route::get('/vueltas/motivos-perdida', [VueltasController::class, 'listarMotivosPerdida']);
    Route::get('/vueltas/{idTurnoOperador}', [VueltasController::class, 'listarVueltas']);
    Route::put('/vueltas/actualizar/{id}', [VueltasController::class, 'actualizarVuelta']);
    Route::get('/vueltas/ultima/{idTurnoOperador}', [VueltasController::class, 'obtenerUltimoIdVuelta']);
    Route::get('/vueltas/en-curso/{idTurnoOperador}', [VueltasController::class, 'obtenerVueltasEnCurso']);
    Route::get('/vueltas_perdidas/{id}', [VueltasController::class, 'obtenerMotivoPerdida']);
});