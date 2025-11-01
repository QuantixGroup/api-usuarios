<?php

namespace App\Http\Controllers;

use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SocioController extends Controller
{
    public function index()
    {
        return Socio::all();
    }

    public function insertar(Request $request)
    {
        $validated = $request->validate([
            'cedula' => 'required|unique:socios,cedula',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email|unique:socios,email',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
            'fecha_nacimiento' => 'nullable|date',
            'departamento' => 'nullable|string',
            'ciudad' => 'nullable|string',
            'ingreso_mensual' => 'nullable|numeric',
            'situacion_laboral' => 'nullable|string',
            'integrantes_familiares' => 'nullable',
            'fecha_ingreso' => 'nullable|date',
            'fecha_egreso' => 'nullable|date',
            'mensaje' => 'nullable|string',
        ]);

        $data = $validated;
        $data['estado'] = 'pendiente';
        if (isset($validated['mensaje'])) {
            $data['motivacion'] = $validated['mensaje'];
            unset($data['mensaje']);
        }

        if (! isset($data['contraseña'])) {
            $data['contraseña'] = Hash::make($data['cedula']);
        }

        $socio = Socio::create($data);

        return response()->json($socio, 201);
    }

    public function mostrar($id)
    {
        $socio = Socio::findOrFail($id);

        return $socio;
    }

    public function actualizar(Request $request, $id)
    {
        $socio = Socio::findOrFail($id);

        $validated = $request->validate([
            'cedula' => 'sometimes|unique:socios,cedula,'.$socio->cedula.',cedula',
            'nombre' => 'sometimes|string',
            'apellido' => 'sometimes|string',
            'email' => 'sometimes|email|unique:socios,email,'.$socio->cedula.',cedula',
            'telefono' => 'sometimes|string',
            'direccion' => 'sometimes|string',
            'fecha_nacimiento' => 'sometimes|date',
            'departamento' => 'sometimes|string',
            'ciudad' => 'sometimes|string',
            'ingreso_mensual' => 'sometimes|numeric',
            'situacion_laboral' => 'sometimes|string',
            'integrantes_familiares' => 'sometimes',
            'fecha_ingreso' => 'sometimes|date',
            'fecha_egreso' => 'sometimes|date',
            'estado' => 'sometimes|string',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'mensaje') {
                $socio->motivacion = $value;

                continue;
            }
            $socio->$key = $value;
        }

        $socio->save();

        return response()->json([
            'message' => 'Socio actualizado',
            'socio' => $socio,
        ], 200);
    }

    public function eliminar($id)
    {
        $socio = Socio::findOrFail($id);
        $socio->delete();

        return response()->json(['message' => 'Socio eliminado']);
    }
}
