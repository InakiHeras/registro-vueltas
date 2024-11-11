<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vuelta extends Model
{
    use HasFactory;

    protected $table = 'vueltas';
    protected $primaryKey = 'IdVuelta';
    public $timestamps = true;

    protected $fillable = [
        'IdTurnoAsistente',
        'IdTurnoOperador',
        'id_vuelta_perdida',
        'HoraSalida',
        'KilometrajeInicial',
        'HoraLlegada',
        'KilometrajeFinal',
        'BoletosVendidos',
        'Estado'
    ];

    public function turnoOperador()
    {
        return $this->belongsTo(TurnoOperador::class, 'IdTurnoOperador', 'IdTurnoOperador');
    }

    public function motivoPerdida()
    {
        return $this->belongsTo(VueltaPerdida::class, 'id_vuelta_perdida', 'id');
    }
}
