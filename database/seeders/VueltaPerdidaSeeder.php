<?php

namespace Database\Seeders;

use App\Models\VueltaPerdida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VueltaPerdidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vueltasPerdidas = [
            ['clave' => 'A', 'motivo' => 'ACCIDENTE', 'responsable' => 'JURIDICO'],
            ['clave' => 'T5', 'motivo' => 'AJUSTES DE MOTOR', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T17', 'motivo' => 'ALINEACION Y BALANCEO', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'A2', 'motivo' => 'APOYO A CAPACITACION', 'responsable' => 'RECURSOS HUMANOS'],
            ['clave' => 'A3', 'motivo' => 'APOYO OTRA RUTA POR SUBS IMAGEN', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'A1', 'motivo' => 'APOYO OTRA RUTA POR SUBS MTO', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'BA', 'motivo' => 'BAJA AFLUENCIA', 'responsable' => 'OPERACIONES'],
            ['clave' => 'T1', 'motivo' => 'CLUTCH', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'SE1', 'motivo' => 'CORTESIA SERV. ESPECIAL', 'responsable' => 'DIRECCION OPERATIVA'],
            ['clave' => 'DT', 'motivo' => 'DETENIDO EN TRANSITO', 'responsable' => 'JURIDICO'],//
            ['clave' => 'T3', 'motivo' => 'ELECTRICO', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'F2', 'motivo' => 'FALTA COMBUSTIBLE', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T13', 'motivo' => 'FRENOS', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T9', 'motivo' => 'HOJALATERIA Y PINTURA', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'I', 'motivo' => 'INASISTENCIA DEL OPERADOR', 'responsable' => 'OPERACIONES'],
            ['clave' => 'T8', 'motivo' => 'LLANTAS', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'MT', 'motivo' => 'MAL TIEMPO', 'responsable' => 'NO APLICA'],
            ['clave' => 'T6', 'motivo' => 'MOTOR REPARACIONES MENORES', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'P2', 'motivo' => 'OPERADOR EN CONFLICTO', 'responsable' => 'OPERACIONES'],
            ['clave' => 'F1', 'motivo' => 'PERSONAL INCOMPLETO', 'responsable' => 'RECURSOS HUMANOS'],//
            ['clave' => 'P1', 'motivo' => 'PERSONAL NO CAPACITADO', 'responsable' => 'RECURSOS HUMANOS'],
            ['clave' => 'L', 'motivo' => 'POR LAVAR LA UNIDAD', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'HE', 'motivo' => 'POR TRABAJAR 3ER TURNO', 'responsable' => 'OPERACIONES'],
            ['clave' => 'CV', 'motivo' => 'TRAFICO', 'responsable' => 'OPERACIONES'],
            ['clave' => 'T7', 'motivo' => 'RADIADORES', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T16', 'motivo' => 'RECALENTAMIENTO DE UNIDAD', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T14', 'motivo' => 'REPARACION POR ACCIDENTE', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T10', 'motivo' => 'RESCATE', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'R', 'motivo' => 'RETARDO DEL OPERADOR', 'responsable' => 'OPERACIONES'],
            ['clave' => 'T15', 'motivo' => 'REVISION AIRE ACONDICIONADO', 'responsable' => 'MANTENIMIENTO'],//
            ['clave' => 'EV', 'motivo' => 'EXCESO DE VELOCIDAD', 'responsable' => 'OPERACIONES'],
            ['clave' => 'PSO', 'motivo' => 'PROBLEMA DE SALUD DEL OPERADOR', 'responsable' => 'OPERACIONES'],
            ['clave' => 'PSF', 'motivo' => 'PROBLEMA DE SALUD DE FAMILIARES', 'responsable' => 'OPERACIONES'],
            ['clave' => 'PSU', 'motivo' => 'PROBLEMA DE SALUD DE USUARIOS', 'responsable' => 'OPERACIONES'],
            ['clave' => 'OE', 'motivo' => 'OPERADOR EN ESTADO DE EBRIEDAD', 'responsable' => 'OPERACIONES'],
            ['clave' => 'OD', 'motivo' => 'OPERADOR DETENIDO POR ACCIDENTE', 'responsable' => 'OPERACIONES'],
            ['clave' => 'CR', 'motivo' => 'CONFLICTOS EN RUTA', 'responsable' => 'OPERACIONES'],
            ['clave' => 'AO', 'motivo' => 'AMENAZAS Y AGRESIONES A OPERADOR', 'responsable' => 'OPERACIONES'],
            ['clave' => 'VU', 'motivo' => 'VANDALISMO A UNIDAD', 'responsable' => 'OPERACIONES'],
            ['clave' => 'RP', 'motivo' => 'RIÑA DE PASAJEROS', 'responsable' => 'OPERACIONES'], //
            ['clave' => 'FE', 'motivo' => 'FALTA DE UNIDAD', 'responsable' => 'OPERACIONES'],
            ['clave' => 'LP', 'motivo' => 'INSTALAR/QUITAR PUBLICIDAD', 'responsable' => 'PUBLICAR'],
            ['clave' => 'SE', 'motivo' => 'SERVICIO ESPECIAL', 'responsable' => 'DIRECCION'],
            ['clave' => 'T12', 'motivo' => 'SERVICIO PREVENTIVO', 'responsable' => 'MANTEMIENTO'],
            ['clave' => 'S2', 'motivo' => 'SISTEMA SMARTTI', 'responsable' => 'TI'],
            ['clave' => 'T4', 'motivo' => 'SUSPENSION', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T11', 'motivo' => 'TALLER EXTERNO', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'T2', 'motivo' => 'TRANSMISIONES', 'responsable' => 'MANTENIMIENTO'],
            ['clave' => 'UD', 'motivo' => 'UNIDAD QUE DESCANSA', 'responsable' => 'OPERACIONES'],
            ['clave' => 'F', 'motivo' => 'FESTIVO', 'responsable' => 'OPERACIONES'],
            ['clave' => 'S3', 'motivo' => 'TELEMETRIA', 'responsable' => 'TELEMETRIA'],
        ];

        foreach ($vueltasPerdidas as $vuelta) {
            VueltaPerdida::create($vuelta);
        }
    }
}
