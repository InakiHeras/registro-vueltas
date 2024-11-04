<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnoOperador extends Model
{
    use HasFactory;

    protected $table = 'turnos_operadores';
    protected $primaryKey = 'IdTurnoOperador';
    public $timestamps = true;

    protected $fillable = [
        'ClaveOperador', 
        'Operador', 
        'Turno', 
        'Ruta', 
        'Zona', 
        'FechaInicio', 
        'FechaFinalizado', 
        'Estatus', 
        'CreatedBy', 
        'UpdatedBy'
    ];

    public function vueltas()
    {
        return $this->hasMany(Vuelta::class, 'IdTurnoOperador', 'IdTurnoOperador');
    }
}
