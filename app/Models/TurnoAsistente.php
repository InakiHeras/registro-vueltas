<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnoAsistente extends Model
{
    use HasFactory;

    protected $table = 'turnos_asistentes';
    protected $primaryKey = 'IdTurnoAsistente';
    public $timestamps = false;

    protected $fillable = [
        'ClaveAsistente',
        'Nombre',
        'Zona',
        'IdUsuario',
        'FechaInicio',
        'FechaFinalizado',
        'Estatus',
        'CreatedBy',
        'UpdatedBy',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'IdUsuario');
    }
}
