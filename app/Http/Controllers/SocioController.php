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
        $password = $request->post('contraseña') ?? $request->post('cedula'); //Esto está para quitar
        $socio->contraseña = Hash::make($password); 

        $socio->save();

        return $socio;
    }

      public function mostrar($id)
    {
        $socio = Socio::findOrFail($id);
        return $socio;
    }

    
    public function actualizar(Request $request, $id)
    {
        $socio = Socio::findOrFail($id);

        if ($request->has('cedula'))                 $socio->cedula = $request->post("cedula");
        if ($request->has('nombre'))                 $socio->nombre = $request->post("nombre");
        if ($request->has('apellido'))               $socio->apellido = $request->post("apellido");
        if ($request->has('telefono'))               $socio->telefono = $request->post("telefono");
        if ($request->has('direccion'))              $socio->direccion = $request->post("direccion");
        if ($request->has('fecha_nacimiento'))       $socio->fecha_nacimiento = $request->post("fecha_nacimiento");
        if ($request->has('departamento'))           $socio->departamento = $request->post("departamento");
        if ($request->has('ciudad'))                 $socio->ciudad = $request->post("ciudad");
        if ($request->has('email'))                  $socio->email = $request->post("email");
        if ($request->has('ingreso_mensual'))        $socio->ingreso_mensual = $request->post("ingreso_mensual");
        if ($request->has('situacion_laboral'))      $socio->situacion_laboral = $request->post("situacion_laboral");
        if ($request->has('integrantes_familiares')) $socio->integrantes_familiares = $request->post("integrantes_familiares");
        if ($request->has('fecha_ingreso'))          $socio->fecha_ingreso = $request->post("fecha_ingreso");
        if ($request->has('fecha_egreso'))           $socio->fecha_egreso = $request->post("fecha_egreso");
        if ($request->has('estado'))                 $socio->estado = $request->post("estado");

        
        $socio->save();

        return response()->json([
            'message' => 'Socio actualizado',
            'socio'   => $socio
        ]);
    }

    public function eliminar($id)
    {
        $socio = Socio::findOrFail($id);
        $socio->delete(); 
        return response()->json(['message' => 'Socio eliminado']);
    }

    
}
