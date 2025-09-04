<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SocioController extends Controller
{
    public function index()
    {
        return Socio::all();
    }

    public function insertar(Request $request)
    {
        $socio = new Socio();

        $socio->cedula = $request->post("cedula");
        $socio->nombre = $request->post("nombre");
        $socio->apellido = $request->post("apellido");
        $socio->telefono = $request->post("telefono");
        $socio->direccion = $request->post("direccion");
        $socio->fecha_nacimiento = $request->post("fecha_nacimiento");
        $socio->departamento = $request->post("departamento");
        $socio->ciudad = $request->post("ciudad");
        $socio->email = $request->post("email");
        $socio->ingreso_mensual = $request->post("ingreso_mensual");
        $socio->situacion_laboral = $request->post("situacion_laboral");
        $socio->estado = 'pendiente'; 
        $socio->integrantes_familiares = $request->post("integrantes_familiares");
        $socio->fecha_ingreso = $request->post("fecha_ingreso");
        $socio->fecha_egreso = $request->post("fecha_egreso");
        $password = $request->post('contraseña') ?? $request->post('cedula');
        $socio->contraseña = Hash::make($password);

        $socio->save();

        return $socio;
    }

    
}
