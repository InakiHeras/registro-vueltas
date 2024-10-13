<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesCode extends Model
{
    use HasFactory;


    protected $table = 'unidades_codes';

    protected $primaryKey = 'IdCode';

    public $timestamps = false;

    protected $fillable = [
        'Unidad',
        'CodeQ',
        'CreatedAt',
        'CreatedBy',
        'UpdatedAt',
        'UpdatedBy',
    ];

    protected $dates = [
        'CreatedAt',
        'UpdatedAt',
    ];
}
