<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VueltaPerdida extends Model
{
    use HasFactory;

    protected $table = 'vueltas_perdidas';

    protected $fillable = [
        'clave',
        'motivo',
        'responsable'
    ];
}
