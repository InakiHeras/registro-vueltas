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
        'ruta',
        'turno',
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

    // Relación con las vueltas
    public function vueltas()
    {
        return $this->hasMany(Vuelta::class, 'IdTurnoAsistente', 'IdTurnoAsistente');
    }
}
