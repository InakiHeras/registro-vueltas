<?php

namespace App\Exports;

use App\Models\Vuelta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Para ajustar automáticamente el tamaño de las columnas
use Maatwebsite\Excel\Concerns\WithStyles;      // Para aplicar estilos
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VueltasExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $idTurnoAsistente;
    protected $nombreAsistente;

    public function __construct($idTurnoAsistente, $nombreAsistente)
    {
        $this->idTurnoAsistente = $idTurnoAsistente;
        $this->nombreAsistente = $nombreAsistente;
    }

    // Recolectar las vueltas registradas en el turno del asistente
    public function collection()
    {
        return Vuelta::where('IdTurnoAsistente', $this->idTurnoAsistente)
            ->with(['turnoOperador', 'motivoPerdida'])
            ->get();
    }

    // Definir los encabezados de la hoja
    public function headings(): array
    {
        return [
            'ID Vuelta',
            'Clave Operador',
            'Nombre Operador',
            'Turno',
            'Ruta',
            'Zona',
            'Hora de Salida',
            'Hora de Llegada',
            'Kilometraje Inicial',
            'Kilometraje Final',
            'Boletos Vendidos',
            'Estado',
        ];
    }

    // Mapear los datos de cada vuelta en una fila
    public function map($vuelta): array
    {
        $turnoOperador = $vuelta->turnoOperador;
        return [
            $vuelta->IdVuelta,
            $turnoOperador->ClaveOperador ?? 'N/A',
            $turnoOperador->Operador ?? 'N/A',
            $turnoOperador->Turno ?? 'N/A',
            $turnoOperador->ruta ?? 'N/A',
            $turnoOperador->Zona ?? 'N/A',
            $vuelta->HoraSalida,
            $vuelta->HoraLlegada,
            $vuelta->KilometrajeInicial,
            $vuelta->KilometrajeFinal,
            $vuelta->BoletosVendidos,
            $vuelta->Estado === 'Perdida' ? ($vuelta->motivoPerdida->clave ?? 'Sin clave') : $vuelta->Estado,
        ];
    }

    // Aplicar estilos a la hoja
    public function styles(Worksheet $sheet)
    {
        // Estilo para la fila de encabezados
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Ajustar el texto de las celdas
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);

        // Opcional: Ajustar el ancho de las columnas automáticamente (ya manejado por ShouldAutoSize)
        // Opcional: Ajustar la altura de las filas automáticamente
        foreach ($sheet->getRowDimensions() as $rowDimension) {
            $rowDimension->setRowHeight(-1);
        }
    }
}
