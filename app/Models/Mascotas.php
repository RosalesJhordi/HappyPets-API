<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascotas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'id_usuario',
    ];
}
