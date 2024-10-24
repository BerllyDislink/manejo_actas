<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    // Nombre de la tabla sesion

    protected $table = 'sesion';

    //No se usa created_at o update_at

    public $timestamps = false;

    //Las columnas que tiene la tabla

    protected $fillable = [
        'IDSESION', 'LUGAR','FECHA', 'HORARIO_INICIO','HORARIO_FINAL','PRESIDENTE','SECRETARIO'
    ];
    
}
