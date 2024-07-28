<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora',
        'id_cliente',
        'id_servicio',
        'nm_mascota',
        'tipo_servicio',
        'duracion',
        'estado',
        'observaciones',
    ];
}
