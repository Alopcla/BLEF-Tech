<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experiencias extends Model
{
    protected $table = 'experiencias';

    protected $fillable = [
        'titulo',
        'descripcion',
        'duracion',
        'personas',
        'precio',
        'imagen'
    ];
}