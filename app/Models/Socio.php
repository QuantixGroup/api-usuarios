<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Socio extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'departamento',
        'ciudad',
        'email',
        'contraseña',
        'ingreso_mensual',
        'situacion_laboral',
        'estado',
        'integrantes_familiares',
        'fecha_ingreso',
        'fecha_egreso',
    ];


}
