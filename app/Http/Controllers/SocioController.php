<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Socio;

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
        $socio->email = $request->post("email");
        $socio->contraseña = $request->post("contraseña");
        $socio->IngresoMensual = $request->post("IngresoMensual");
        $socio->profesion = $request->post("profesion");
        $socio->estado = $request->post("estado");
        $socio->IntegrantesFamiliares = $request->post("IntegrantesFamiliares");
        $socio->FechaIngreso = $request->post("FechaIngreso");
        $socio->FechaEgreso = $request->post("FechaEgreso");

        $socio->save();

        return $socio;
    }
}
