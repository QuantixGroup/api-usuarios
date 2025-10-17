<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'cedula';
    public $incrementing = false;
    protected $keyType = 'string';

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
        'foto_perfil',
        'contraseña',
        'ingreso_mensual',
        'situacion_laboral',
        'estado_civil',
        'estado',
        'integrantes_familiares',
        'fecha_ingreso',
        'fecha_egreso',
        'motivacion',
    ];
}
