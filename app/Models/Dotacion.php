<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dotacion extends Model
{
    public $agente;
    public $nombreAgente;
    public $descripcionUnidad;
    public $descripcionRuta;
    public $descripcionZona;
    public $descripcionTurno;

    public function __construct($agente, $nombreAgente, $descripcionUnidad, $descripcionRuta, $descripcionZona, $descripcionTurno)
    {
        $this->agente = $agente;
        $this->nombreAgente = $nombreAgente;
        $this->descripcionUnidad = $descripcionUnidad;
        $this->descripcionRuta = $descripcionRuta;
        $this->descripcionZona = $descripcionZona;
        $this->descripcionTurno = $descripcionTurno;
    }
}

